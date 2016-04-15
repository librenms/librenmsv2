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

/* ajaxSetup()
 * ======
 * Initial ajax setup call
 *
 * @type Function
 * @Usage: $.Util.ajaxSetup()
 */
$.Util.ajaxSetup = function(authtoken) {
    var headers = {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')};
    if (typeof authtoken != 'undefined') {
        var auth = {'Authorization': 'Bearer ' + authtoken};
        $.extend(headers, auth);
    }

    return $.ajaxSetup({
        headers: headers
    });
};

/* formatBitsPS()
 * ======
 * Converts raw bits to bits per second.
 *
 * @type Function
 * @Usage: $.Util.formatBitsPS(bits,decimals=2,base=1000)
 */
$.Util.formatBitsPS = function(bits,decimals,base) {
   var bps = ['bps', 'Kbps', 'Mbps', 'Gbps', 'Tbps', 'Pbps', 'Ebps', 'Zbps', 'Ybps'];
   return $.Util.formatDataUnits(bits,decimals,bps,base);
};

/* formatDataUnit()
 * ======
 * Converts raw bits or bytes human readable format.
 *
 * @type Function
 * @Usage: $.Util.formatBitsPS(bits,decimals=2,display=['Byte', 'Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']base=1000)
 */
$.Util.formatDataUnits = function(units,decimals,display,base) {
   if(!units) return '';
   if(display === undefined) display = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
   if(units == 0) return units + display[0];
   base = base || 1000; // or 1024 for binary
   var dm = decimals || 2;
   var i = Math.floor(Math.log(units) / Math.log(base));
   return parseFloat((units / Math.pow(base, i)).toFixed(dm)) + display[i];
};

$.Util.updateNotifications = function() {
    $.ajax({
        url: '/api/notifications',
        dataType: 'json',
        success: function (data) {
            var nItems = data.data;
            console.log(nItems);
            var nCount = $('.notifications-menu > a > span');
            nCount.text(nItems.length);

            var nList = $('#dropdown-notifications-list');
            nList.empty();
            for(var i=0;i<5&&i<nItems.length;i++) {
                console.log(i);
                var item = $('<li>');
                var link = item.append('<a href="/notifications/'+nItems[i].id+'" title="'+nItems[i].body+'"><i class="fa fa-bell text-aqua"></i> '+nItems[i].title+'</a>');
                nList.append(item);
            }
        }
    });
};

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
                    $.Util.updateNotifications();
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
};

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
                    console.log(data);
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
};


/* ajaxCall()
 * ======
 * Ajax call
 *
 * @type Function
 * @Usage: $.Util.ajaxCall()
 */
$.Util.ajaxCall = function(type, url, form) {
    form = $(form);
    return $.ajax({
        type: type,
        url: url,
        data: form.serialize(),
        dataType: "json"
    });
};

/* toastr()
 * ========
 * toastr call
 */
$.Util.toastr = function(type, message) {
    toastr.type(message);
};
