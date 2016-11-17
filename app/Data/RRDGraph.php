<?php
/**
 * RRDGraph.php
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

namespace App\Data;


class RRDGraph extends RRD
{
    protected $supported_formats = ['png'];

    public function __construct($definitions, $start, $end, $width, $height)
    {
        $args = " graph - -s $start -e $end  --width $width --height $height ".
            "--alt-autoscale-max --rigid -E -c BACK#EEEEEE00 -c SHADEA#EEEEEE00 -c SHADEB#EEEEEE00 -c \
            FONT#000000 -c CANVAS#FFFFFF00 -c GRID#a5a5a5 -c MGRID#FF9999 -c FRAME#5e5e5e -c ARROW#5e5e5e \
            -R normal --font LEGEND:8:DejaVuSansMono --font AXIS:7:DejaVuSansMono --font-render-mode normal ".
            $definitions;

        parent::__construct($args);
    }

    /**
     * Return the output from this data source
     * May be base64 encoded PNG, Json Data, or CSV Data
     *
     * @param string $format png, json, or csv
     * @return string
     */
    public function fetch($format)
    {
        $this->checkFormatSupported($format);
        return base64_encode($this->run());
    }
}
