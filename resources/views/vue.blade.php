@extends('layouts.app')

@section('content')

    <div id="app"><!-- include this in app layout? -->
        <example></example>
    </div>


    <h1>Gridstack.js and Vue.js</h1>

    {{--https://troolee.github.io/gridstack.js/--}}
    <div class="grid-stack" id="app2">

        <dashboard-widget v-for="widget in widgetsList" v-bind:widget="widget"></dashboard-widget>

    </div>


    </div>




@endsection

@section('pagejs')
    @parent
    {{--$.fn.size = function(){--}}
    {{--return this.length;--}}
    {{--};--}}
    {{--<script src="{{ url('js/lodash.min.js') }}"></script>--}}
    {{--<script src="{{ url('js/gridstack.min.js') }}"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.0/jquery-ui.js"></script>

    <script type="text/javascript">
        /*Gridstack*/

        $(function () {
            var options = {
                cellHeight: 80,
                verticalMargin: 10
            };
            $('.grid-stack').gridstack(options);
        });

//        $('.grid-stack').gridstack({
//            cellHeight: 80,
//            verticalMargin: 10,
//            draggable: {
//                handle: '.draggable',
//                scroll: true,
//                appendTo: 'body'
//            },
//            animate: true
//        });


        var app2 = new Vue({
            el: '#app2',
            data: {
                widgetsList: [
                    {text: 'Vegetables', width: '2', height: '2', title: 'one'},
                    {text: 'Cheese', width: '2', height: '4', title: 'two'},
                    {text: 'Whatever else humans are supposed to eat', width: '4', height: '2', title: 'three'}
                ]
            }
        })
    </script>

@endsection
