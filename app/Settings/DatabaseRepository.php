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


use Exception;
use Illuminate\Database\Connection;

class DatabaseRepository
{
    private $connection;
    private $table;

    public function __construct(Connection $connection, $table)
    {
        $this->connection = $connection;
        $this->table = $table;
    }


    public function has($key)
    {
        return $this->table()->where('key', '=', $key)->count() > 0 ? true : false;
    }

    public function get($key, $default = null)
    {
        $results = $this->table()->where('key', 'LIKE', $key . '%')->get(['key', 'value']);
        if (is_array($results))
        {
            return $this->objsToArray($results);
        } else {
            $value = $results->value;
            return is_null($value) ? $default : $value;
        }
    }

    public function set($key, $value = null)
    {
        //handle array value
        if (is_array($value)) {
            foreach ($value as $subkey => $subval) {
                $this->set($key . '.' . $subkey, $subval);
                return;
            }
        }
        //insert or update
        try {
            $this->table()->insert(compact('key', 'value'));
        } catch (Exception $e) {
            $this->table()->where('key', '=', $key)->update(compact('value'));
        }
    }

    public function forget($key)
    {
        $this->table()->where('key', $key)->delete();
    }

    public function all()
    {
        $settings = $this->table()->get();
        return $this->objsToArray($settings);
    }

    private function table()
    {
        return $this->connection->table($this->table);
    }

    private function objsToArray($objs) {
        $ret = array();
        foreach ($objs as $obj) {
            $ret[$obj->key] = $obj->value;
        }
        return $ret;
    }
}