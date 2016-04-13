<?php
/*
 * Copyright (C) 2016 Tony Murray <murraytony@gmail.com>
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
/**
 * Settings.php
 *
 * @package    LibreNMS
 * @author     Tony Murray <murraytony@gmail.com>
 * @copyright  2016 Tony Murray
 * @license    @license http://opensource.org/licenses/GPL-3.0 GNU Public License v3 or later
 */
namespace App;


use App\Models\DbConfig;
use Cache;
use Config;
use Illuminate\Contracts\Config\Repository as ConfigContract;

// adds the possibility to replace the default Config facade

class Settings implements ConfigContract
{
    /**
     * The tag for the cache.
     *
     * @var string
     */
    public static $cache_tag = "Settings";
    /**
     * The amount of time in minutes to store values in cache
     *
     * @var int
     */
    private $cache_time;

    /**
     * Settings constructor.
     */
    public function __construct()
    {
        $this->cache_time = env('CACHE_LIFETIME', 60);
    }

    /**
     * Set a key value pair into the Settings store.
     * 
     * @param string $key A . separated path to this setting
     * @param array|null $value A value or an array. If value is an array it will be converted to a . separate path(s) concatinated onto the given key
     */
    public function set($key, $value = null)
    {
        if (is_array($value)) {
            // repeat until value contains no arrays
            foreach ($value as $k => $v) {
                if (!empty($key)) {
                    if (is_string($k) && !str_contains($k, '.') && DbConfig::exactKey($key)->exists() && DbConfig::key($key)->count() == 1) {
                        // check that we aren't trying to set an array onto an existing value only setting
                        throw new \Exception("Attempting to set array value to existing non-array value at the key '".$key."'");
                    }
                    else {
                        // we are not at the leaf yet, add this chunk to the key and recurse
                        $this->set($key.'.'.$k, $v);
                    }
                }
                else {
                    // a leaf, recurse one last time
                    $this->set($k, $v);
                }
            }
        }
        else {
            // make sure we can save this
            if ($this->isReadOnly($key)) {
                throw new \Exception("The setting '".$key."' is read only");
            }

            // flush the cache and save the value in db and cache
            $this->flush($key);
            DbConfig::updateOrCreate(['config_name' => $key], ['config_value' => $value]);
            Cache::tags(self::$cache_tag)->put($key, $value, $this->cache_time);
        }

    }

    /**
     * Get a value from the Settings store.
     *
     * @param string $key A full or partial . separated key.
     * @param null $default If the key isn't found, return this value. By default undefined keys return null.
     * @return mixed If the $key is a full path, a bare value will be returned.  If it is a partial path, a nested array will be retuned.
     */
    public function get($key, $default = null)
    {
        // return value from cache or fetch it and return it
        return Cache::tags(self::$cache_tag)->remember($key, $this->cache_time, function() use ($key, $default) {
            // fetch the value from config.php first
            if (Config::has('config.'.$key)) {
                $config_data = Config::get('config.'.$key, $default);
                if (!is_array($config_data)) {
                    // return the value from config.php if it is a value
                    return $config_data;
                }
            }

            // fetch the value from the database
            $db_data = DbConfig::key($key)->get(['config_name', 'config_value']);

            if (count($db_data) == 1 && $db_data->first()->config_name == $key) {
                // return a value if we are getting one item
                return $db_data->first()->config_value;
            }
            elseif (count($db_data) >= 1) {
                // convert the collection to an array
                $result = self::collectionToArray($db_data, $key);

                // if we have config_data, merge them
                if (isset($config_data)) {
                    return array_replace_recursive($result, $config_data);
                }
                else {
                    return $result;
                }
            }
            // we couldn't find the key, return the default
            return $default;
        });
    }

    /**
     * Convert an Eloquent Collection into a nested array
     *
     * @param $data \Illuminate\Database\Eloquent\Collection The Collection.
     * @param string $prefix Path to prepend. Do not include trailing .
     * @return array The resulting nested array.
     */
    private static function collectionToArray($data, $prefix = "")
    {
        $tree = array();
        foreach ($data as $item) {
            $key = $item->config_name;
            if (starts_with($key, $prefix)) {
                $key = substr($key, strlen($prefix));
            }
            $parts = explode('.', trim($key, '.'));

            $temp = &$tree;
            foreach ($parts as $part) {
                $temp = &$temp[$part];
            }
            $temp = $item->config_value;
            unset($temp);
        }
        return $tree;
    }

    /**
     * Check if the key is defined in the Settings store.
     * 
     * @param string $key Only full paths will return true.
     * @return bool 
     */
    public function has($key)
    {
        return (Cache::tags(self::$cache_tag)->has($key) || Config::has('config.'.$key) || DbConfig::key($key)->exists());
    }

    /**
     * Check if the key is read only.  This is when the setting is defined in config.php.
     *
     * @param string $key The path to check
     * @return bool
     */
    public function isReadOnly($key)
    {
        return Config::has('config.'.$key);
    }

    /**
     * Forget a key.  Gets to forgotten keys will return null instead of the default.
     *
     * @param $key string Only works for full paths.
     */
    public function forget($key)
    {
        // set to null to prevent falling back to Config
        DbConfig::key($key)->update(['config_value' => null]);
        Cache::tags(self::$cache_tag)->forget($key);
    }

    /**
     * Get all settings defined in the Settings store.
     * 
     * @return array A nested array of all settings.
     */
    public function all()
    {
        // no caching :(
        $config_settings = Config::all()['config'];
        $db_settings = self::collectionToArray(DbConfig::all());
        return array_replace_recursive($config_settings, $db_settings);
    }

    // ---- Local Utility functions ----

    /**
     * Clear the settings cache.
     * If path is set, only clear the path and it's parents.
     *
     * @param string $key The path to clear.
     */
    public function flush($key = null)
    {
        if (is_null($key)) {
            // Clear all cache
            Cache::tags(self::$cache_tag)->flush();
        }
        else {
            // Clear specific path
            $path = [];
            foreach (explode('.', $key) as $element) {
                $path[] = $element;
                Cache::tags(self::$cache_tag)->forget(join('.', $path));
            }
        }
    }

    /**
     * Prepend a value onto an array configuration value.
     *
     * @param  string $key
     * @param  mixed $value
     * @return void
     */
    public function prepend($key, $value)
    {
        // TODO: Implement prepend() method.
    }

    /**
     * Push a value onto an array configuration value.
     *
     * @param  string $key
     * @param  mixed $value
     * @return void
     */
    public function push($key, $value)
    {
        // TODO: Implement push() method.
    }
}
