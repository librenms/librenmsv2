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
                <button type="button" class="btn btn-box-tool"><i class="fa fa-wrench"></i></button>
                <button type="button" class="btn btn-box-tool" @click="removeWidget"><i class="fa fa-trash"></i></button>
                </div></div>
            <div class="box-body">
                <availability-map v-if="widget.widget_id == 1" v-bind:settings="widget.settings"></availability-map>
            </div>
        </div>
    </div>
</template>

<script>
    import AvailabilityMap from './widgets/AvailabilityMap.vue'

    export default {
        components: {
            'availability-map': AvailabilityMap
        },
        props: ['widget'],
        methods: {
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
        }
    }
</script>
