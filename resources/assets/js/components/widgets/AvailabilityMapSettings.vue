<!--
  ~ AvailabiityMapSettings.vue
  ~
  ~ -Description-
  ~
  ~ This program is free software: you can redistribute it and/or modify
  ~ it under the terms of the GNU General Public License as published by
  ~ the Free Software Foundation, either version 3 of the License, or
  ~ (at your option) any later version.
  ~
  ~ This program is distributed in the hope that it will be useful,
  ~ but WITHOUT ANY WARRANTY; without even the implied warranty of
  ~ MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
  ~ GNU General Public License for more details.
  ~
  ~ You should have received a copy of the GNU General Public License
  ~ along with this program.  If not, see <http://www.gnu.org/licenses/>.
  ~
  ~ @package    LibreNMS
  ~ @link       http://librenms.org
  ~ @copyright  2017 Tony Murray
  ~ @author     Tony Murray <murraytony@gmail.com>
  -->

<template>
    <div>
        <div class="form-group">
            <label for="tileSize" class="col-sm-3">Tile Size</label>
            <div class="col-sm-9">
                <input id="tileSize" type="text" class="form-control" v-model="size">
            </div>
        </div>
        <div class="form-group">
            <label for="tileTypes" class="col-sm-3">Show</label>
            <div class="col-sm-9">
                <select id="tileTypes" v-model="mode" class="form-control">
                    <option value="0">Only Devices</option>
                    <option value="1">Only Services</option>
                    <option value="2">Devices and Services</option>
                </select>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['settings'],
        data() {
            return {
                size: this.settings.tile_width,
                mode: this.settings.mode
            }
        },
        watch: {
            size() {
                this.$emit('input', this.size)
            },
            mode() {
                this.$emit('input', this.mode)
            }
        }
    }
</script>
