<template>
    <div>
        <form class="form-inline">
            <div class="form-group">
                <select class="form-control" v-model="selected">
                    <option v-for="dashboard in dashboards" v-bind:value="dashboard.dashboard_id">
                        {{ dashboard.dashboard_name }}
                    </option>
                </select>
            </div>
            <div class="form-group">
                <a href="#" data-toggle="control-sidebar" class="btn btn-primary"><i class="fa fa-gears"></i></a>
            </div>
        </form>
        <br />

        <div class="grid-stack">
            <dashboard-widget
                    v-for="widget in widgets"
                    v-on:remove="removeWidget(widget.user_widget_id)"
                    v-bind:key="widget.user_widget_id"
                    v-bind:widget="widget">
            </dashboard-widget>
        </div>
    </div>
</template>

<script>
    window.Gridstack = require('gridstack');
    require('gridstack/src/gridstack.jQueryUI.js'); // for draggable, etc

    import DashboardWidget from './DashboardWidget.vue'

    export default {
        components: {
            'dashboard-widget': DashboardWidget
        },
        data() {
            return {
                selected: 0,
                dashboards: [],
                widgets: [],
                errors: []
            };
        },
        mounted() {
            window.axios.get('api/dashboard')
                .then(response => {
                    this.dashboards = response.data.dashboards;
                    for (let id in this.dashboards) {
                        this.selected = id;
                        break;
                    }
                })
                .catch(e => {
                    this.errors.push(e)
                });

            $('.grid-stack').gridstack({
                cellHeight: 80,
                verticalMargin: 10,
                draggable: {
                    handle: '.draggable',
                    scroll: true,
                    appendTo: 'body'
                },
            });
        },
        watch: {
            'selected': function () {
                if (this.selected === 0 || !(this.selected in this.dashboards)) {
                    return;
                }

                // changing dashboards, remove all nodes from gridstack, but don't let it update the dom
                let grid = $('.grid-stack').data('gridstack');
                if (grid) {
                    grid.removeAll(false);
                }

                window.axios.get('api/dashboard/' + this.selected)
                    .then(response => {
                        this.widgets = response.data.widgets;
                    })
                    .catch(e => {
                        this.errors.push(e)
                    });
            }
        },
        methods: {
            removeWidget(id) {
                console.log('removing '+id);
                this.widgets = $.grep(this.widgets, function(widget) {
                    return widget.user_widget_id !== id;
                })
            }
        }
    }
</script>
