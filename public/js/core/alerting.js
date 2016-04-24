/**
 * public/js/core/alerting.js
 *
 * JS functions for alerting
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    LibreNMS
 * @link       http://librenms.org
 * @copyright  2016 Neil Lathwood
 * @author     Neil Lathwood <neil@lathwood.co.uk>
 */

$.Alerting = {};

$(document).ready(function(){
    LaravelDataTables['dataTableBuilder'].on('click', 'a', function(){
        var button   = $(this);
        var alert_id = $(this).data('id');
        var state    = $(this).data('state');
        if (state === 1) {
            var new_state = 2;
            var new_class = 'btn-danger';
            var old_class = 'btn-success';
            var new_icon  = 'volume-off';
        }
        else {
            var new_state = 1;
            var new_class = 'btn-success';
            var old_class = 'btn-danger';
            var new_icon  = 'volume-up';
        }
        data         = {
            state: new_state
        }
        $.Util.apiAjaxPATCHCall('/api/alerting/alerts/'+alert_id, data)
            .done(function(content) {
                LaravelDataTables['dataTableBuilder'].draw(false);
            })
            .fail(function(err,msg) {
                toastr.error("Couldn't update this alert");
            });
    });
});
