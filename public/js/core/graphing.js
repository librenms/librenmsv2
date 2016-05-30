/* LibreNMS Graphing
 *
 * @type Object
 * @description $.Graphing is the main object for this graphing class.
 *              It's used for to call for graphs and place the result
 *              onto the page.
 */
$.Graphs = {};

/* callGraph()
 * ========
 * Sets up the users dashboard
 */
$.Graphs.callGraph = function($ctx) {
    $.ajax({
        url: '/api/graph-data/bits/json?source=rrd-json',
        async: true,
        dataType: 'json',
        type: "post",
        data: 'input={"start": "-1y", "end": "-300", "hostname": "localhost", "port": "id8"}',
    }).done(function (data) {
        var ctx_$ctx = new Chart($ctx, {
            type: 'line',
            data: {
                labels: data.labels,
                datasets: data.data
            },
            options: {
                animation: {
                    duration: 0,
                },
                animate: false,
                fullWidth: false,
                responsive: true,
                legend: {
                    position: 'bottom',
                },
                hover: {
                    mode: 'label'
                },
                scales: {
                    yAxes: [{
                        stacked: false,
                        ticks: {
                            callback: function(tick, index, ticks) {
                                if (data.tick == 'BKMGT') {
                                    return $.Graphs.BKMGT(tick, index, ticks);
                                }
                                else {
                                    return tick;
                                }
                            }
                        },

                    }],
                    xAxes: [{
                        stacked: true,
                        type: 'time',
                    }],
                }
            }
        });
    });
};

// Functions to convert graph data
$.Graphs.BKMGT = function(tick, index, ticks) {
    var abs_tick = Math.abs(tick);
    if (abs_tick >= 1000000000000)     { return tick / 1000000000000 + "T" }
    else if (abs_tick >= 1000000000)   { return tick / 1000000000 + "G" }
    else if (abs_tick >= 1000000)      { return tick / 1000000 + "M" }
    else if (abs_tick >= 1000)         { return tick / 1000 + "K" }
    else if (abs_tick < 1 && tick > 0) { return tick.toFixed(2) }
    else if (abs_tick === 0)           { return '' }
    else                               { return tick }
}
