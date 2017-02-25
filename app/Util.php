<?php
/**
 * Util.php
 *
 * Common Utility functions
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

namespace App;

class Util
{
    /**
     * Merge arrays, concatenate the values of any common keys
     *
     * @param array ...
     * @return array
     */
    public static function arrayMergeConcat()
    {
        $out = [];
        // loop through the arguments
        foreach (func_get_args() as $arr) {
            // loop through each array
            foreach ($arr as $key => $value) {
                // If the same key exists in the $out array
                if (array_key_exists($key, $out)) {
                    // concat the values
                    $out[$key] = $out[$key].$arr[$key];
                } else {
                    $out[$key] = $arr[$key];
                }
            }
        }
        return $out;
    }

    /**
     * Checks if the given variable is a json encoded string.
     *
     * @param string $string The string to check
     * @return bool true if this is json, otherwise false
     */
    public static function isJson($string)
    {
        if (!is_string($string)) {
            return false;
        }
        json_decode($string, true);
        return (json_last_error() == JSON_ERROR_NONE);
    }


    /**
     * @param int $seconds
     * @return string
     */
    public static function formatUptime($seconds)
    {
        if (empty($seconds)) {
            $seconds = 0;
        }
        $from = new \DateTime("@0");
        $to = new \DateTime("@$seconds");
        return $from->diff($to)->format('%a d, %h h, %i m and %s s');
    }
}
