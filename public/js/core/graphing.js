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
        data: 'input={"start": "-1y", "end": "-300", "hostname": "localhost", "port": "id24425"}',
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
$.Graphs.callPNGGraph = function($ctx) {
    $.ajax({
        url: '/api/graph-data/bits/png?source=rrd-png',
        async: true,
        dataType: 'png',
        type: "post",
        data: 'input={"start": "-1y", "end": "-300", "hostname": "localhost", "port": "id8"}',
    }).done(function (data) {

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
        data: 'input={"start": "'+options.start+'", "end": "'+options.end+'", "device_id": "'+options.device+'", "id": "'+options.id+'"}',
    }).done(function (output) {
        graph_options = Object.assign(
            {
                labelsKMB: true,
                legend: 'follow',
                connectSeparatedPoints: false,
                fillGraph: true,
                axes: {
                    x: {
                        drawAxis: false
                    },
                    y: {
                        drawAxis: false
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
                console.log('test');
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
        item.style.width=width;
        item.style.height=height;
        div_id = el.attr('id');
        data = {
            type: type,
            width: width,
            height: height,
            start: start,
            end: end,
            device: device,
            id: id,
            options: options
        }
        $.Graphs.callCsvGraph(div_id, data);
    }

};