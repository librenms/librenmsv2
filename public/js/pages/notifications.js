$.Notifications = {};

/* markNotificationRead()
 * ======
 * Using an ajax request it will mark the particular notification as read
 *
 * @type Function
 * @Usage: $.Util.markNotificationRead(baseurl)
 */
$.Notifications.markNotification = function(baseurl) {
    $(document).on("click", ".notification", function() {
        $(this).attr("disabled", true);
        var id     = $(this).data('id');
        var action = $(this).data('action');
        $.ajax({
            type: 'PATCH',
            url: baseurl+'/notifications/'+id+'/'+action,
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
                    $.Util.updateNotificationMenu(baseurl);
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
$.Notifications.newNotification = function(form) {
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
        $.Util.ajaxCall('PUT','/notifications', $(form).serialize())
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
};