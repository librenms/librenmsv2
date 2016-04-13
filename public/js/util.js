/* LibreNMS Util
 *
 * @type Object
 * @description $.Util is the main object for this utility class.
 *              It's used for implementing functions and options related
 *              to the template. Keeping everything wrapped in an object
 *              prevents conflict with other plugins and is a better
 *              way to organize our code.
 */
$.Util = {};


/* formatBitsPS()
 * ======
 * Converts raw bits to bits per second.
 *
 * @type Function
 * @Usage: $.Util.formatBitsPS(bits,decimals=2,base=1000)
 */
$.Util.formatBitsPS = function(bits,decimals,base) {
   var bps = ['bps', 'Kbps', 'Mbps', 'Gbps', 'Tbps', 'Pbps', 'Ebps', 'Zbps', 'Ybps']
   return $.Util.formatDataUnits(bits,decimals,bps,base)
}

/* formatDataUnit()
 * ======
 * Converts raw bits or bytes human readable format.
 *
 * @type Function
 * @Usage: $.Util.formatBitsPS(bits,decimals=2,display=['Byte', 'Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']base=1000)
 */
$.Util.formatDataUnits = function(units,decimals,display,base) {
   if(!units) return '';
   if(display === undefined) var display = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
   if(units == 0) return units + display[0];
   base = base || 1000; // or 1024 for binary
   var dm = decimals || 2;
   var i = Math.floor(Math.log(units) / Math.log(base));
   return parseFloat((units / Math.pow(base, i)).toFixed(dm)) + display[i];
}

/* markNotificationRead()
 * ======
 * Using an ajax request it will mark the particular notification as read
 *
 * @type Function
 * @Usage: $.Util.markNotificationRead(url)
 */
$.Util.markNotification = function(url) {
    $(document).on("click", ".notification", function() {
        $(this).attr("disabled", true);
        var id     = $(this).data('id');
        var action = $(this).data('action');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'PATCH',
            url: url+'/'+id+'/'+action,
            dataType: "json",
            success: function (data) {
                if (data.statusText === "OK" ) {
                    toastr.info('Notification has been marked as '+action);
                    if (action !== 'sticky' && action !== 'unsticky')
                    {
                        $("#"+id).fadeOut();
                    }
                    else {
                        window.location.href="";
                    }
                    if (action === 'unread')
                    {
                        $('#notification-count > span').text(parseInt($("#notification-count").text()) + 1);
                    }
                    else if (action === 'read')
                    {
                        $('#notification-count > span').text(parseInt($("#notification-count").text()) - 1);
                    }
                }
                else {
                    $(this).attr("disabled", false);
                    toastr.error('We had a problem marking this notification as '+action)
                }
            },
            error: function(err,msg) {
                $(this).attr("disabled", false);
                toastr.error("Couldn't mark this notification as "+action);
            }
        });
    });
}

/* newNotification()
 * ======
 * Process the new notification form
 *
 * @type Function
 * @Usage: $.Util.newNotification()
 */
$.Util.newNotification = function(form) {
    $('#notification-form').fadeOut(0);
    $("#show-notification").on("click", function() {
        $('#notification-form').fadeToggle();
    });
    $("#create-notification").on("click", function(event) {
        $('.form-error').each(function()
        {
            $(this).html('');
        });
        $.Util.ajaxSetup();
        event.preventDefault();
        $.Util.ajaxCall('PUT','/notifications', form)
            .done(function(data) {
                if (data.statusText === "OK" ) {
                    toastr.info('Notification has been created');
                    setTimeout(function() {
                        location.reload(1);
                    }, 1000);
                }
                else {
                    toastr.error('We had a problem creating your notification');
                }
            })
            .fail(function(err,msg) {
                if (err.status === 422)
                {
                    response = jQuery.parseJSON(err.responseText);
                    jQuery.each(response, function(field, message)
                    {
                        $(form + ' [name=' + field + ']').next('.form-error').html(message);
                    });
                }
                else {
                    toastr.error("Couldn't create this notification");
                }
            });
    });
}

/* ajaxSetup(token)
 * ======
 * Initial ajax setup call
 *
 * @type Function
 * @Usage: $.Util.ajaxSetup()
 */
$.Util.ajaxSetup = function(token) {
    return $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Authorization': 'Bearer ' + token
        }
    });
}

/* ajaxCall()
 * ======
 * Ajax call
 *
 * @type Function
 * @Usage: $.Util.ajaxCall()
 */
$.Util.ajaxCall = function(type, url, data) {
    return $.ajax({
        type: type,
        url: url,
        data: data,
        dataType: "json"
    });
}

/* apiAjaxGetCall()
 * ======
 * Api Ajax call via get
 *
 * @type Function
 * @Usage: $.Util.apiAjaxGetCall()
 */
$.Util.apiAjaxGetCall = function(url) {
    return $.ajax({
        type: 'GET',
        url: url,
        dataType: "json"
    });
}

/* apiAjaxPATCHCall()
 * ======
 * Api Ajax call via PATCH
 *
 * @type Function
 * @Usage: $.Util.apiAjaxPATCHCall()
 */
$.Util.apiAjaxPATCHCall = function(url, data) {
    return $.ajax({
        type: 'PATCH',
        url: url,
        data: data,
        dataType: "json"
    });
}

/* apiAjaxDELETECall()
 * ======
 * Api Ajax call via DELETE
 *
 * @type Function
 * @Usage: $.Util.apiAjaxDELETECall()
 */
$.Util.apiAjaxDELETECall = function(url) {
    return $.ajax({
        type: 'DELETE',
        url: url,
        dataType: "json"
    });
}

/* toastr()
 * ========
 * toastr call
 */
$.Util.toastr = function(type, message) {
    toastr.type(message);
}

/* setupDashboard()
 * ========
 * Sets up the users dashboard
 */
$.Util.setupDashboard = function() {
    var options = {
        cellHeight: 80,
        verticalMargin: 10,
        draggable: {
            handle: '.draggable',
            scroll: true,
            appendTo: 'body'
        },
        animate: true
    };
    return $('.grid-stack').gridstack(options).data('gridstack');
}

/* addWidget(grid, data)
 * ========
 * Sets up the users dashboard
 */
$.Util.addWidget = function(grid, data, token) {
    if (data.settings) {
        data.settings = $.parseJSON(data.settings);
    }
    if (data.autoPosition == '') {
        data.autoPosition = false;
    }
    $.Util.refreshDashboardWidget(token, data);
 }

/* refreshDashboardWidget()
 * ========
 * Refreshes the data in a widget
 */
$.Util.refreshDashboardWidget = function(token, data, refresh=false)
{
    id = data.widget_id;
    $.Util.ajaxSetup(token);
    $.Util.apiAjaxGetCall('/api/dashboard-widget/'+id)
        .done(function(response) {
            settings = response.widget;
            content  = response.content.content;
            if (refresh === false)
            {
                el = $('<div id="'+data.user_widget_id+'"><div class="grid-stack-item-content box box-primary box-solid"><div class="box-header with-border draggable"><h3 class="box-title">' + settings.widget_title + '</h3><div class="box-tools pull-right"><button type="button" class="btn btn-box-tool" id="edit-widget" data-id="' + data.user_widget_id + '" onClick="$.Util.editWidget(this, \'' + token + '\')"><i class="fa fa-pencil"></i></button> <button type="button" class="btn btn-box-tool" id="remove-widget" data-id="' + data.user_widget_id + '" onClick="$.Util.removeWidget(this, \'' + token + '\')"><i class="fa fa-close"></i></button></div></div><div class="box-body">'+content+'</div></div></div>');
                grid.addWidget(el, data.col, data.row, data.size_x, data.size_y, data.autoPosition, null, null, null, null, data.user_widget_id);
            }
            else {
                new_refresh = data.refresh*1000;
                setTimeout(function() {
                    $('#'+data.user_widget_id).find('.grid-stack-item-content .box-body').html(content);
                    $.Util.refreshDashboardWidget(token,data,true);
                },
                new_refresh);
            }
        })
        .fail(function(err,msg) {
            toastr.error("Couldn't create the widget " + data.title);
        });
}

/* updateWidget()
 * ======
 * Updates the widgets details in the DB
 */
$.Util.updateWidget = function(target, token)
{
    data = {
        id:     target.getAttribute('data-gs-id'),
        x:      target.getAttribute('data-gs-x'),
        y:      target.getAttribute('data-gs-y'),
        width:  target.getAttribute('data-gs-width'),
        height: target.getAttribute('data-gs-height')
    }
    $.Util.ajaxSetup(token);
    $.Util.apiAjaxPATCHCall('/api/dashboard-widget/'+data['id'], data)
        .done(function(content) {
        })
        .fail(function(err,msg) {
            toastr.error("Couldn't update this widget!");
        });
}

/* removeWidget()
 * ======
 * Remove the selected widget
 *
 * @type Function
 * @Usage: $.Util.removeWidget()
 */
$.Util.removeWidget = function(data, token) {
    $(document).ready(function(){
            $this = $(data);
            el = $this.closest('.grid-stack-item');
            $.Util.ajaxSetup(token);
            $.Util.apiAjaxDELETECall('/api/dashboard-widget/'+$this.data('id'))
                .done(function(content) {
                    $('.grid-stack').data('gridstack').removeWidget(el);
                })
                .fail(function(err,msg) {
                    toastr.error("Couldn't remove this widget!");
                });
    });
}

/* editWidget()
 * ======
 * Edit the selected widget
 *
 * @type Function
 * @Usage: $.Util.editWidget()
 */
$.Util.editWidget = function(data, token) {
    $(document).ready(function(){
        $this = $(data);
        //content = $this.closest('.grid-stack-item').find('.box-body').html();
        id = $this.data('id');
        $.Util.apiAjaxGetCall('/api/dashboard-widget/'+id+'/settings')
            .done(function(response) {
                content = response.content;
                $this.closest('.grid-stack-item').find('.box-body').html(content);
            })
            .fail(function(err,msg) {
                toastr.error("Couldn't retrieve this widgets settings page " + data.title);
            });
    });
}

$.Util.dashboardActions = function(token, grid) {
    $(document).ready(function(){
        $('#add-dashboard').click('', function(event) {
            event.preventDefault;
            $('#show-edit').collapse('hide');
            $('#show-delete').collapse('hide');
            $('#show-add').collapse('toggle');
        });
        $('#edit-dashboard').click('', function(event) {
            event.preventDefault;
            $('#show-add').collapse('hide');
            $('#show-delete').collapse('hide');
            $('#show-edit').collapse('toggle');
        });
        $('#delete-dashboard').click('', function(event) {
            event.preventDefault;
            $('#show-add').collapse('hide');
            $('#show-edit').collapse('hide');
            $('#show-delete').collapse('toggle');
        });
        $('#confirm-delete-dashboard').click('', function(event) {
            event.preventDefault;
            $this = $(this);
            $.Util.ajaxSetup(token);
            $.Util.apiAjaxDELETECall('/api/dashboard/'+$this.data('id'))
                .done(function(content) {
                    $('.grid-stack').data('gridstack').removeAll();
                    toastr.info("Dashboard has been removed");
                    setTimeout(function() {
                        window.location.replace('/');
                    }, 2000);
                })
                .fail(function(err,msg) {
                    toastr.error("Couldn't delete this dashboard!");
                });
        });
        $('#clear-dashboard').click('', function(event) {
            event.preventDefault;
            $this = $(this);
            $.Util.ajaxSetup(token);
            $.Util.apiAjaxDELETECall('/api/dashboard/'+$this.data('id')+'/clear')
            .done(function(content) {
                $('.grid-stack').data('gridstack').removeAll();
                toastr.info("Dashboard has been cleared");
            })
            .fail(function(err,msg) {
                toastr.error("Couldn't clear this dashboard!");
            });
        });
        $('#confirm-add-dashboard').submit(function(event) {
            event.preventDefault(event);
            $.Util.ajaxSetup(token);
            data = $("#confirm-add-dashboard").serialize();
            $.Util.ajaxCall('POST','/api/dashboard', data)
                .done(function(data) {
                    if (data.statusText === "OK" ) {
                        window.location.replace('/dashboard/'+data.dashboard_id);
                    }
                    else {
                        toastr.error('We had a problem creating your dashboard');
                    }
                })
                .fail(function(err,msg) {
                    if (err.status === 422)
                    {
                        response = jQuery.parseJSON(err.responseText);
                        jQuery.each(response, function(field, message)
                        {
                            $(form + ' [name=' + field + ']').next('.form-error').html(message);
                        });
                    }
                    else {
                        toastr.error("Couldn't create this dashboard");
                    }
                });
        });
        $('#confirm-edit-dashboard').submit(function(event) {
            event.preventDefault(event);
            $.Util.ajaxSetup(token);
            form         = $("#confirm-edit-dashboard");
            dashboard_id = form.data('dashboard_id');
            name         = $("#confirm-edit-dashboard input[name=name]").val();
            access       = $("#confirm-edit-dashboard select[name=access]").val()
            data = {
                name:   name,
                access: access
            }
            $.Util.apiAjaxPATCHCall('/api/dashboard/'+dashboard_id, data)
                .done(function(data) {
                    if (data.statusText === "OK" ) {
                        window.location.replace('/dashboard/'+dashboard_id);
                    }
                    else {
                        toastr.error('We had a problem updating your dashboard');
                    }
                })
                .fail(function(err,msg) {
                    if (err.status === 422)
                    {
                        response = jQuery.parseJSON(err.responseText);
                        jQuery.each(response, function(field, message)
                        {
                            $("#confirm-edit-dashboard" + ' [name=' + field + ']').next('.form-error').html(message);
                        });
                    }
                    else {
                        toastr.error("Couldn't update this dashboard");
                    }
                });
        });
        $('#widget_id').on('change', function()
        {
            tmp_data     = $('#widget_id').val().split(",");
            dashboard_id = $('#widget_id').data('dashboard_id');
            if (tmp_data)
            {
                widget_id  = tmp_data[0];
                post_data = {
                    col: '',
                    row: '',
                    size_x: tmp_data[1],
                    size_y: tmp_data[2],
                    widget_id: tmp_data[0],
                    title: tmp_data[3],
                    dashboard_id: dashboard_id,
                    autoPosition: true
                }
                $.Util.ajaxSetup(token);
                $.Util.ajaxCall('POST','/api/dashboard-widget', post_data)
                .done(function(data) {
                    if (data.statusText === "OK" ) {
                        post_data.user_widget_id = data.user_widget_id;
                        $.Util.addWidget(grid, post_data, token, true);
                    }
                    else {
                        toastr.error('We had a problem adding this widget');
                    }
                })
                .fail(function(err,msg) {
                    toastr.error("Couldn't add this widget!");
                });
            }
            else {
                toastr.error("Fatal, Couldn't add this widget");
            }
        });
    });
}
