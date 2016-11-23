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
use Settings;

class QueryBuilderFilter
{
    public static function getAlertFilter()
    {
        return json_encode(self::generateMacroFilter('alert.macros.rule', self::generateTableFilter()));
    }

    private static function generateMacroFilter($setting, $filter = [])
    {
        foreach (Settings::get($setting, []) as $key => $value) {
            $filter[] = [
                'id'        => 'macros.'.$key,
                'type'      => 'integer',
                'input'     => 'radio',
                'values'    => ['1' => 'Yes', '0' => 'No'],
                'operators' => ['equal'],
            ];
        }
        return $filter;
    }

    private static function generateTableFilter($filter = [])
    {
        // check if the database schema has changed
        $db = DB::table('migrations')->pluck('migration');
        $cached = Cache::get('migrations_list', []);

        if ($db != $cached) {
            Cache::forget('query_builder_table_filter');
            Cache::forever('migrations_list', $db);
        }

        // return the table filter merged with $filter, fetch from cache if available
        return array_merge($filter, Cache::rememberForever('query_builder_table_filter', function () {
            $tableFilter = [];
            $schema = DB::getDoctrineSchemaManager();

            // Doctrine DBAL has issues with enums, pretend they are strings
            $schema->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

            $tables = $schema->listTables();
            foreach ($tables as $table) {
                $columns = $schema->listTableColumns($table->getName());
                $tableName = $table->getName();

                // only allow tables with a direct association to device_id
                if (!$table->hasColumn('device_id')) {
                    continue;
                }

                foreach ($columns as $column) {
                    $columnName = $column->getName();

                    // ignore device id columns, except in the devices table
                    if ($columnName == 'device_id' && $tableName != 'devices') {
                        continue;
                    }

                    $columnType = self::getColumnType($column->getType()->getName());

                    // ignore unsupported types (such as binary and blob)
                    if (is_null($columnType)) {
                        continue;
                    }

                    $tableFilter[] = [
                        'id'   => $tableName.'.'.$columnName,
                        'type' => $columnType,
                    ];
                }
            }
            return $tableFilter;
        }));
    }

    private static function getColumnType($type)
    {
        switch ($type) {
            case 'text':
//                return 'textarea';
            case 'string':
                return 'string';

            case 'integer':
            case 'smallint':
            case 'bigint':
                return 'integer';

            case 'double':
            case 'float':
            case 'decimal':
                return 'double';

            case 'date':
                return 'date';

            case 'time':
                return 'time';

            case 'datetime':
                return 'datetime';

            case 'boolean':
                return 'boolean';
        }
        // binary, blob
        return null;
    }

    public static function getGroupFilter()
    {
        return json_encode(self::generateMacroFilter('alert.macros.group', self::generateTableFilter()));
    }
}
