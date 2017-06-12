<!--
  ~ AnimatedInteger.vue
  ~
  ~ Animates number transitions (copied from vue.js documentation)
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
    <span>{{ tweeningValue }}</span>
</template>


<script>
    window.TWEEN = require('tween.js');

    export default {
        props: {
            value: {
                type: Number,
                required: true
            }
        },
        data: function () {
            return {
                tweeningValue: 0
            }
        },
        watch: {
            value: function (newValue, oldValue) {
                this.tween(oldValue, newValue)
            }
        },
        mounted: function () {
            this.tween(0, this.value)
        },
        methods: {
            tween: function (startValue, endValue) {
                let vm = this;
                let animationFrame;

                function animate(time) {
                    TWEEN.update(time);
                    animationFrame = requestAnimationFrame(animate)
                }

                new TWEEN.Tween({tweeningValue: startValue})
                    .to({tweeningValue: endValue}, 500)
                    .onUpdate(function () {
                        vm.tweeningValue = this.tweeningValue.toFixed(0)
                    })
                    .onComplete(function () {
                        cancelAnimationFrame(animationFrame)
                    })
                    .start();
                animationFrame = requestAnimationFrame(animate)
            }
        }
    };
</script>

