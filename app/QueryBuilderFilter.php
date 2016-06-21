<?php
/**
 * QueryBuilderFilter.php
 *
 * -Description-
 *
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
 *
 * @package    LibreNMS
 * @link       http://librenms.org
 * @copyright  2016 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace app;


use Cache;
use DB;

class QueryBuilderFilter
{
    /**
     *
     */
    public static function generateFilter()
    {
        //TODO use variable for cache time or check if it should be invalidated
//        Cache::forget('query_builder_filter');

        return Cache::remember('query_builder_filter', 30, function() {
            $filter = [];
            $schema = DB::getDoctrineSchemaManager();

            // Doctrine DBAL has issues with enums, pretend they are strings
            $schema->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

            $validTypes = ['string', 'integer', 'double', 'date', 'time', 'datetime', 'boolean'];
            $ignoreTypes = ['blob', 'binary'];

            $tables = $schema->listTables();
            foreach ($tables as $table) {
                $columns = $schema->listTableColumns($table->getName());
                $tableName = $table->getName();

                // only allow tables with direct association to device_id for now
                if (!$table->hasColumn('device_id')) {
                    continue;
                }

                foreach ($columns as $column) {
                    $item = [];
                    $type = $column->getType()->getName();
                    $name = $column->getName();

                    switch ($type) {
                        case 'text':
//                            $item['input'] = 'textarea';
                        case 'string':
                            $item['type'] = 'string';
                            break;

                        case 'integer':
                        case 'smallint':
                        case 'bigint':
                            $item['type'] = 'integer';
                            break;

                        case 'double':
                        case 'float':
                        case 'decimal':
                            $item['type'] = 'double';
                            break;

                        case 'date':
                            $item['type'] = 'date';
                            break;

                        case 'time':
                            $item['type'] = 'time';
                            break;

                        case 'datetime':
                            $item['type'] = 'datetime';
                            break;

                        case 'boolean':
                            $item['type'] = 'boolean';
                            break;

                    }

                    if (!isset($item['type'])) {
                        if (!in_array($type, $ignoreTypes)) {
                            dd($type);
                        }
                        continue;
                    }


                    // ignore device id columns, except in the devices table
                    if ($name == 'device_id') {
                        if ($tableName != 'devices') {
                            continue;
                        }
                    }

                    $item['id'] = $tableName.'.'.$name;
                    $filter[] = $item;
                }
            }
            return json_encode($filter);
        });
    }
}