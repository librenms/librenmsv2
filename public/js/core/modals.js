/*
 * modals.js
 *
 * Generic javascript for controlling modal dialogs
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
 * @copyright  2016 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

// generic modal
$(document).on('click', '.showModal', function () {
    var modalTitle = $(this).attr('data-modal-title');
    $('#modalTitle').text(modalTitle);

    var content = $('#modalContent');
    content.html('<div style="text-align:center"><i class="fa fa-spin fa-spinner"></i> Loading...</div>');

    var footer = $('#modalFooter');
    footer.find('.modalFooterContent').remove();

    $.ajax({
        url: $(this).attr('data-href'),
        dataType: 'html',
        success: function (data) {
            content.html(data);
            footer.prepend(content.find('.modalFooterContent'));
        },
        error: function (data) {
            toastr.error('Could not load dialog content');
            $('#generalModal').modal('hide');
        }
    });
});

$(document).on('click keyup', '.modalSave,.modalForm input', function (e) {
    // filter bad events
    if (e.type === 'keyup' && e.keyCode !== 13) return;
    if (e.target.type == 'textarea') return;
    if (e.type === 'click' && !$(this).hasClass('modalSave')) return;

    e.preventDefault();

    var form = $('.modalForm');

    $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: form.serialize(),
        cache: false,
        dataType: 'json',
        success: function (data) {
            LaravelDataTables['dataTableBuilder'].draw(false);
            $('#generalModal').modal('hide');
            toastr.success(data.message);
        },
        error: function (data) {
            if (data.responseText) {
                var errors = $.parseJSON(data.responseText);
                form.find('.help-block').empty();
                $.each(errors, function (field, text) {
                    $('input[name ="' + field + '"]').parent().find('.help-block').text(text);
                });
            } else {
                toastr.error(data.statusText);
            }
        }
    });


    return false;
});

// delete modal
$(document).on('click', '.deleteModal', function () {
    // copy the action from this button to the form
    $("#modalDeleteForm").prop('action', $(this).attr('data-href'));
});

$(document).on('click', '.modalDeleteConfirm', function (e) {
    e.preventDefault();

    $.ajax({
        url: $('#modalDeleteForm').attr('action'),
        type: 'delete',
        cache: false,
        dataType: 'json',
        success: function (data) {
            LaravelDataTables['dataTableBuilder'].draw(false);
            toastr.success(data.message);
        },
        error: function (data) {
            console.log(data);
            if('responseText' in data) {
                var message = $.parseJSON(data.responseText).message;
                toastr.error(message);
            } else {
                toastr.error(data.statusText)
            }
        }
    });
    $('#deleteModal').modal('hide');

    return false;
});
