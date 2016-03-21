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
namespace App\Settings;


use App\Models\DbConfig;
use Cache;
use Config;
use DB;
use Illuminate\Contracts\Config\Repository as ConfigContract;

// adds the possibility to replace the default Config facade

class Settings implements ConfigContract
{
    private $cache_time;

    public function __construct()
    {
        $this->cache_time = env('CACHE_LIFETIME', 60);
    }

    public function set($key, $value = null)
    {
        if (is_array($value)) {
            $value = self::arrayToPath($value, $key);
            foreach ($value as $k => $v) {
                DbConfig::updateOrCreate(['config_name' => $k], ['config_value' => $v]);
                Cache::put($k, $v, $this->cache_time);
            }
        }
        else {
            DbConfig::updateOrCreate(['config_name' => $key], ['config_value' => $value]);
            Cache::put($key, $value, $this->cache_time);
        }
        return $value;
    }


    public function get($key, $default = null)
    {
        // return value from cache or fetch it and return it
        return Cache::remember($key, $this->cache_time, function () use ($key, $default) {
            $db_data = DbConfig::key($key)->get(['config_name', 'config_value']);

            if (count($db_data) == 1 && $db_data->first()->config_name == $key) {
                // return a bare value if we are getting one item
                return $db_data->first()->config_value;
            }
            elseif (count($db_data) >= 1) {
                $result = self::collectionToArray($db_data, $key);
                $config = Config::get('config.' . $key, $default);
                if (!is_null($config)) {
                    $result = array_replace_recursive($config, $result);
                }
                return $result;
            }
            else {
                return Config::get('config.' . $key, $default);
            }

        });
    }


    public function has($key)
    {
        return (Cache::has($key) || Config::has($key) || DbConfig::exactKey($key)->exists());
    }

    public function forget($key)
    {
        // set to null to prevent falling back to Config
        DbConfig::key($key)->update(['config_value' => null]);
        Cache::forget($key);
    }

    public function all()
    {
        // no caching :(
        $config_settings = Config::all()['config'];
        $db_settings = self::collectionToArray(DbConfig::all());
        return array_replace_recursive($config_settings, $db_settings);
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

    // ---- Local Utility functions ----

    private static function collectionToArray($data, $prefix = "")
    {
        $tree = array();
        foreach ($data as $item) {
            $key = $item->config_name;
            if (substr($key, 0, strlen($prefix)) == $prefix) {
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

    private static function arrayToPath($array, $prefix = "")
    {
        return self::recursive_keys($array, $prefix);
    }

    private static function recursive_keys(array $array, $prefix = "", array $path = array())
    {
        if ($prefix != "") {
            $prefix = trim($prefix, '.') . '.';
        }
        $result = array();
        foreach ($array as $key => $val) {
            $currentPath = array_merge($path, array($key));
            if (is_array($val)) {
                $result = array_merge($result, self::recursive_keys($val, $prefix, $currentPath));
            }
            else {
                $result[$prefix . join('.', $currentPath)] = $val;
            }
        }
        return $result;
    }
}