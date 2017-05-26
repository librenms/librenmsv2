<template>
    <div class="grid-stack">
        <dashboard-widget v-for="widget in widgetsList" v-bind:widget="widget"></dashboard-widget>
    </div>
</template>

<script>
    $(function () {
        var options = {
            cellHeight: 80,
            verticalMargin: 10,
            draggable: {
                handle: '.draggable',
                scroll: true,
                appendTo: 'body'
            },
        };
        $('.grid-stack').gridstack(options);
    });

    import DashboardWidget from './DashboardWidget.vue'

    export default {
        components: {
            'dashboard-widget': DashboardWidget
        },
        data() {
            return {
                widgetsList: [
                    {text: 'Vegetables', width: '2', height: '2', title: 'one'},
                    {text: 'Cheese', width: '2', height: '4', title: 'two'},
                    {text: 'Whatever else humans are supposed to eat', width: '4', height: '2', title: 'three'}
                ]
            };
        }
    }
</script>
