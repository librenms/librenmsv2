<template>
    <div class="grid-stack-item"
         :id="'user_widget_'+widget.user_widget_id"
         :data-gs-id="widget.user_widget_id"
         :data-gs-width="widget.size_x"
         :data-gs-height="widget.size_y"
         :data-gs-x="widget.col"
         :data-gs-y="widget.row"
    >
        <div class="grid-stack-item-content box box-primary box-solid">
            <div class="box-header with-border draggable"><h3 class="box-title"> {{ widget.title }} </h3>
                <div class="box-tools pull-right">
                    <button @click="toggleSettings" type="button" class="btn btn-box-tool">
                        <i class="fa fa-wrench" :class="{'inset-shadow': showSettings}"></i>
                    </button>
                    <button @click="removeWidget" type="button" class="btn btn-box-tool">
                        <i class="fa fa-trash"></i>
                    </button>
                </div></div>
            <div class="box-body">
                <component v-if="showSettings"
                           :is="widgetType + '-settings'"
                           :settings="settings">
                </component>
                <component
                        v-show="!showSettings"
                        :is="widgetType"
                        :settings="settings">
                </component>
            </div>
        </div>
    </div>
</template>

<script>
    import AvailabilityMap from './widgets/AvailabilityMap.vue'
    import AvailabilityMapSettings from './widgets/AvailabilityMapSettings.vue'

    export default {
        data() {
            return {
                showSettings: false
            }
        },
        components: {
            'availability-map': AvailabilityMap,
            'availability-map-settings': AvailabilityMapSettings
        },
        props: ['widget'],
        methods: {
            toggleSettings() {
                this.showSettings = !this.showSettings;
            },
            removeWidget() {
                let grid = $('.grid-stack').data('gridstack');
                grid.removeWidget($('#user_widget_' + this.widget.user_widget_id), false);
                this.$emit('remove');
            }
        },
        mounted() {
            // if gridstack is already running, notify it of the new widget
            let grid = $('.grid-stack').data('gridstack');
            if (grid) {
                grid.makeWidget('#user_widget_'+this.widget.user_widget_id);
            }
        },
        computed: {
            widgetType() {
                let types = {
                    1: 'availability-map'
                };
                return types[this.widget.widget_id];
            },
            settings() {
                return JSON.parse(this.widget.settings);
            }
        }
    }
</script>

<style>
    .inset-shadow {
        text-shadow: 0px 1px 0px rgba(50, 50, 50, 0.75);
    }
</style>
