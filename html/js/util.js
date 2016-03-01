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
                if( data.statusText === "OK" ) {
                    toastr.info('Notification has been marked as '+action);
                    if (action !== 'sticky' && action !== 'unsticky')
                    {
                        $("#"+id).fadeOut();
                    }
                    else {
                        window.location.href="";
                    }
                }
                else {
                    $(this).attr("disabled", false);
                    toastr.info('We had a problem marking this notification as '+action)
                }
            },
            error: function(err,msg) {
                $(this).attr("disabled", false);
                toastr.error("Couldn't mark this notification as "+action);
            }
        });
    });
}
