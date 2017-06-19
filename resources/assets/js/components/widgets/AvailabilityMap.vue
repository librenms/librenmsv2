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
        <transition name="fade">
            <h5 class="counts" v-if="loaded">
            <span data-toggle="tooltip" class="badge bg-green" v-bind:title="counts.up + ' Devices up'">
                <i class="fa fa-check"></i> <animated-integer v-bind:value="counts.up"></animated-integer>
            </span>
                <span data-toggle="tooltip" class="badge bg-yellow" v-bind:title="counts.warn + ' Recently rebooted'">
                <i class="fa fa-exclamation-triangle"></i> <animated-integer v-bind:value="counts.warn"></animated-integer>
            </span>
                <span data-toggle="tooltip" class="badge bg-red" v-bind:title="counts.down + ' Devices down'">
                <i class="fa fa-exclamation-circle"></i> <animated-integer v-bind:value="counts.down"></animated-integer>
            </span>
        </h5>
        </transition>

        <transition-group name="list-complete" tag="a">
            <a role="button"
               data-toggle="tooltip"
               v-for="device in devices"
               v-bind:key="device.device_id"
               v-bind:href="'devices/' + device.device_id"
               class="device-badge list-complete-item btn btn-xs"
               v-bind:class="getClass(device)"
               v-bind:title="device.hostname + ' ' + secondsToString(device.uptime)"
               v-bind:style="badgeStyle"
            ></a>
        </transition-group>
    </div>
</template>

<script>
    export default {
        props: ['settings'],
        data() {
            return {
                widget_id: 1,
                loaded: false,
                uptime_warning: 86400,
                tile_width: 15,
                devices: [],
                interval: null
            }
        },
        mounted() {
            this.loadData();

            // TODO something smarter?
            this.interval = setInterval(function () {
                this.loadData();
            }.bind(this), 300000);

            this.startListening();
        },
        beforeDestroy() {
            clearInterval(this.interval);
            Echo.leave('devices');
        },
        computed: {
            counts() {
                let counts = {up: 0, down: 0, warn: 0};
                for (let id in this.devices) {
                    if (this.devices.hasOwnProperty(id)) {
                        if (this.devices[id].status) {
                            if (this.checkUptime(this.devices[id].uptime)) {
                                counts.warn++
                            } else {
                                counts.up++
                            }
                        } else {
                            counts.down++
                        }
                    }
                }
                return counts;
            },
            badgeStyle() {
                return {
                    'min-width': this.tile_width + 'px',
                    'min-height': this.tile_width + 'px',
                    'border-radius': (this.tile_width / 8) + 'px'
                }
            }
        },
        methods: {
            startListening() {
                Echo.private('devices')
                    .listen('DeviceUpdated', (e) => {
                        Vue.set(this.devices, e.device.device_id, e.device);
                    })
                    .listen('DeviceCreated', (e) => {
                        Vue.set(this.devices, e.device.device_id, e.device);
                    })
                    .listen('DeviceDeleted', (e) => {
                        Vue.delete(this.devices, e.device.device_id);
                    });

                Echo.private('settings.uptime_warning')
                    .listen('SettingUpdated', (e) => {
                        this.uptime_warning = e.value;
                    });
            },
            loadData() {
                window.axios.get('api/settings/uptime_warning')
                    .then(response => {
                        this.uptime_warning = response.data;
                    });

                window.axios.get('api/devices?fields=device_id,hostname,status,uptime')
                    .then(response => {
                        this.devices = _.keyBy(response.data.devices, d => d.device_id);
                        this.loaded = true;
                    });
            },
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
    .counts {
        text-align: center;
        margin-top: 0;
    }

    .device-badge {
        border-radius: 2px;
        margin: 1px;
        padding: 0;
    }

</style>
