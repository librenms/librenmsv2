/* LibreNMS Graphing
 *
 * @type Object
 * @description $.Graphing is the main object for this graphing class.
 *              It's used for to call for graphs and place the result
 *              onto the page.
 */
$.Graphs = {};

/* callJsonGraph()
 * ========
 * Sets up the users dashboard
 */
$.Graphs.callJsonGraph = function($ctx) {
    $.ajax({
        url: '/api/graph-data/bits/json?source=rrd-json',
        async: true,
        dataType: 'json',
        type: "post",
        data: 'input={"start": "-1y", "end": "-300", "hostname": "localhost", "port": "id24425"}'
    }).done(function (output) {
        tmpdata = JSON.stringify(output.data);
        labels = JSON.stringify(output.labels);
        new Dygraph($ctx,
            tmpdata
        );
    });
};

/* callPNGGraph()
 * ========
 * Sets up the users dashboard
 */
$.Graphs.callPNGGraph = function($ctx, options = []) {
    $.ajax({
        url: '/api/graph-data/'+options.type+'/png?source=rrd',
        async: true,
        type: "post",
        data: 'input={"start": "'+options.start+'", "end": "'+options.end+'", "device_id": "'+options.device+'", "id": "'+options.id+'", "width": "' + options.width + '", "height": "' + options.height + '"}'
    }).done(function (output) {
        $('#'+$ctx).html('<img src="data:image/png;base64,' + output + '" />');
        setTimeout(function() {
                $.Graphs.callPNGGraph($ctx, options);
            },
            60000);
    });
};

/* callCsvGraph()
 * ========
 * Sets up the users dashboard
 */
$.Graphs.callCsvGraph = function($ctx, options = []) {
    $.ajax({
        url: '/api/graph-data/'+options.type+'/csv?source=rrd',
        async: true,
        type: "post",
        data: 'input={"start": "'+options.start+'", "end": "'+options.end+'", "device_id": "'+options.device+'", "id": "'+options.id+'"}'
    }).done(function (output) {
        graph_options = Object.assign(
            {
                labelsKMB: true,
                legend: 'follow',
                connectSeparatedPoints: false,
                fillGraph: true,
                axes: {
                    x: {
                        drawAxis: options.drawaxis
                    },
                    y: {
                        drawAxis: options.drawaxis
                    }
                },
                colors: colourSets[colourMaps[options.type]]},
            options.options);
        new Dygraph($ctx,
            output,
            graph_options
        );
        setTimeout(function() {
                $.Graphs.callCsvGraph($ctx, options);
            },
            60000);
    });
};

$.Graphs.buildGraphs = function() {
    // Build graphs
    var graphs = document.getElementsByClassName("show-graph");
    for(var i = 0; i < graphs.length; i++)
    {
        item = graphs.item(i);
        el = $(item);
        type = el.data('type');
        width = el.data('width');
        height = el.data('height');
        start = el.data('start');
        end = el.data('end');
        device = el.data('device');
        id = el.data('id');
        options = el.data('options') || '';
        drawaxis = el.data('drawaxis');
        graph = el.data('graph') || 'csv';
        if (drawaxis != false) {
            drawaxis = true;
        }
        item.style.width=width;
        item.style.height=height;
        div_id = el.attr('id');

        if (graph == 'png') {
            width = document.getElementById(div_id).offsetWidth - 100;
            height = document.getElementById(div_id).offsetHeight;
        }

        data = {
            type: type,
            width: width,
            height: height,
            start: start,
            end: end,
            device: device,
            id: id,
            options: options,
            drawaxis: drawaxis
        };

        if (graph == 'csv') {
            $.Graphs.callCsvGraph(div_id, data);
        } else {
            $.Graphs.callPNGGraph(div_id, data);
        }
    }

};