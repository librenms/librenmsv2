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
 * DatabaseRepository.php
 *
 * @package    LibreNMS
 * @author     Tony Murray <murraytony@gmail.com>
 * @copyright  2016 Tony Murray
 * @license    @license http://opensource.org/licenses/GPL-3.0 GNU Public License v3 or later
 */
namespace App\Settings;


use App\Models\DbConfig;
use App\Models\Notification;

class DatabaseRepository
{
    // 'config_name', 'config_value'

    public function has($key)
    {
        return DbConfig::exactKey($key)->exists();
    }

    public function get($key, $default = null)
    {
        $results = DbConfig::key($key)->get(['config_name', 'config_value']);
        if (count($results) > 1) {
            return $this->collectionToArray($results);
        }
        elseif (count($results) == 1) {
            $entry = $results->first();
            if($entry->config_name != $key) { //FIXME: better test
                // trim the prefix
                $local_key = substr($entry->config_name, strlen($key) + 1);
                return [$local_key => $entry->config_value];
            }

            $value = $entry->config_value;
            return is_null($value) ? $default : $value;
        }
        else {
            return $default;
        }
    }

    private function collectionToArray($collection)
    {
        $ret = array();
        foreach ($collection as $item) {
            $ret[$item->config_name] = $item->config_value;
        }
        return $ret;
    }

    public function set($key, $value = null)
    {
        $config = new DbConfig;
        $config->config_name = $key;
        $config->config_value = $value;
        //FIXME: dummy data
        $config->config_default = "";
        $config->config_descr = "";
        $config->config_group = "";
        $config->config_group_order = "";
        $config->config_sub_group = "";
        $config->config_sub_group_order = "";

        $config->save();
    }

    public function reset($key)
    {
        DbConfig::key($key)->delete();
    }

    public function forget($key)
    {
        // set to null to prevent falling back to Config
        DbConfig::key($key)->update(['config_value' => null]);
    }

    public function all()
    {
        $settings = DbConfig::all();
        return $this->objsToArray($settings);
    }

    private function objsToArray($objs)
    {
        $ret = array();
        foreach ($objs as $obj) {
            $ret[$obj->key] = $obj->value;
        }
        return $ret;
    }
}