<!--
  ~ AvailabilityMap.vue
  ~
  ~ Dashboard widget that shows a graphic of all devices up/down status
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
        <h5 style="text-align:center; margin-top: 0;">
            <span data-toggle="tooltip" class="badge bg-green" v-bind:title="counts.up + ' Devices up'"><i class="fa fa-check"></i> {{ counts.up }}</span>
            <span data-toggle="tooltip" class="badge bg-yellow" v-bind:title="counts.warn + ' Recently rebooted'"><i
                    class="fa fa-exclamation-triangle"></i> {{ counts.warn }}</span>
            <span data-toggle="tooltip" class="badge bg-red" v-bind:title="counts.down + ' Devices down'"><i class="fa fa-exclamation-circle"></i> {{ counts.down }}</span>
        </h5>

        <a role="button"
           v-for="device in devices"
           v-bind:href="'devices/' + device.device_id"
           class="btn btn-xs"
           v-bind:class="getClass(device)"
           v-bind:title="device.hostname + ' ' + secondsToString(device.uptime)"
        ></a>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                widget_id: 1,
                counts: {up: '', down: '', warn: ''},
                uptime_warning: 86400,
                devices: [],
                settings: {
                    tile_width: 10
                }
            }
        },
        mounted() {
            window.axios.get('api/widget-data/' + this.widget_id)
                .then(response => {
                    this.counts = response.data.counts;
                    this.devices = response.data.devices;
                    this.uptime_warning = response.data.uptime_warning;
                });
        },
        methods: {
            checkUptime(uptime) {
                return uptime < this.uptime_warning && uptime != 0
            },
            secondsToString(seconds) {
                let output = [];
                let numyears = Math.floor(seconds / 31536000);
                if (numyears > 0) {
                    output.push(numyears + ' yrs');
                }
                let numdays = Math.floor((seconds % 31536000) / 86400);
                if (numdays > 0) {
                    output.push(numdays + ' days');
                }
                let numhours = Math.floor(((seconds % 31536000) % 86400) / 3600);
                if (numhours > 0 && numyears === 0) {
                    output.push(numhours + ' hrs');
                }
                let numminutes = Math.floor((((seconds % 31536000) % 86400) % 3600) / 60);
                if (numminutes > 0 && numyears === 0 && numdays === 0) {
                    output.push(numminutes + ' mins');
                }
                let numseconds = (((seconds % 31536000) % 86400) % 3600) % 60;
                if (numyears === 0 && numdays === 0 && numhours === 0) {
                    output.push(numseconds + ' secs');
                }
                return output.join(', ');
            },
            getClass(device) {
                if (device.status) {
                    if (this.checkUptime(device.uptime)) {

                        return 'btn-warning'
                    } else {
                        return 'btn-success'
                    }
                }

                return 'btn-danger';
            }
        }
    }
</script>

<style scoped>
    a {
        min-height: 15px;
        min-width: 15px;
        border-radius: 2px;
        margin: 1px;
        padding: 0;
    }

</style>

hhhhhmmhj;i;p[8p0
