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
                dashboardId: 33,
                widgetsList: [],
                errors: []
            };
        },
        mounted() {
            window.axios.get('api/dashboard/' + this.dashboardId)
                .then(response => {
                    // JSON responses are automatically parsed.
                    console.log(response.data)
                    this.widgetsList = response.data.widgets
                })
                .catch(e => {
                    this.errors.push(e)
                })

        }
    }
</script>
