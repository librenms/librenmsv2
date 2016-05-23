/*
 * settings.js
 *
 * Control JS for the settings page
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

// Filter sections
$('#settingsFilter').on('keyup search', function (event) {
    event.preventDefault();
    var search = $(this).val().toLowerCase();
    $('.content section').each(function () {
        var $this = $(this);
        if (search.length == 0 || $this.text().toLowerCase().indexOf(search) >= 0) {
            $this.show();
        } else {
            $this.hide();
        }
    });
});

// sortable control
$('.sortable').sortable({
    handle: '.drag-handle',
    create: function () {
        var $this = $(this);
        if ($this.hasClass('readonly')) {
            $this.sortable('disable');
            $('span.drag-handle', this).remove();
        }
    },
    update: function () {
        var $this = $(this);
        // Disabling sorting
        $this.sortable('disable');
        // Adding effect
        $this.addClass('pulsate');

        var key = $this.attr('id');
        var data = $this.sortable('toArray', {attribute: 'data-value'});

        $.ajax({
            type: 'POST',
            url: settings_url,
            data: {
                type: 'settings-array',
                key: key,
                value: data
            },
            dataType: 'html',
            success: function () {
                $this.sortable('enable');
                $this.removeClass('pulsate');

                $this.closest('.form-group').addClass('has-success');
                setTimeout(function () {
                    $this.closest('.form-group').removeClass('has-success');
                }, 2000);
            },
            error: function () {
                $this.sortable('cancel');
                $this.sortable('enable');
                $this.removeClass('pulsate');

                $this.closest('.form-group').addClass('has-error');
                setTimeout(function () {
                    $this.closest('.form-group').removeClass('has-error');
                }, 2000);
            }
        });
    }
});

// text input control
$(".content input[type='text']").on('blur keyup', function (e) {
    if (e.type === 'keyup' && e.keyCode !== 13) return;
    var $this = $(this);
    var data = $this.val();

    var original = $this.data('original-value');
    if (data == original) return;

    var key = $this.attr('name');
    if (typeof $this.data('index') !== "undefined") {
        key = key + '.' + $this.data('index');
    }

    $this.next('i').remove();
    $this.after('<i class="fa fa-spin fa-spinner fa-lg"></i>');

    $.ajax({
        type: 'POST',
        url: settings_url,
        data: {
            type: 'settings-value',
            key: key,
            value: data
        },
        dataType: 'html',
        success: function () {
            $this.data('original-value', data);
            $this.closest('.form-group').addClass('has-success');
            $this.next('i').remove();
            $this.after('<i class="fa fa-check fa-lg text-success"></i>');
            setTimeout(function () {
                $this.closest('.form-group').removeClass('has-success');
                $this.next('i').remove();
            }, 2000);
        },
        error: function () {
            $this.val(original);
            $this.closest('.form-group').addClass('has-error');
            $this.next('i').remove();
            $this.after('<i class="fa fa-close fa-lg text-danger"></i>');
            setTimeout(function () {
                $this.closest('.form-group').removeClass('has-error');
                $this.next('i').remove();
            }, 2000);
        }
    });
});

// radio input control
$(".content input[type='radio']").change(function () {
    var $this = $(this);
    var key = $this.attr('id');
    var data = $this.data('value');

    $this.closest('label').after('<i class="fa fa-spin fa-spinner fa-lg"></i>');

    $.ajax({
        type: 'POST',
        url: settings_url,
        data: {
            type: 'settings-value',
            key: key,
            value: data
        },
        dataType: 'html',
        success: function () {
            $this.parent().siblings('.current').removeClass('current');
            $this.parent().addClass('current');
            $this.closest('label').next('i').remove();

            $this.closest('.form-group').addClass('has-success');
            setTimeout(function () {
                $this.closest('.form-group').removeClass('has-success');
            }, 2000);
        },
        error: function () {
            $this.parent().removeClass('active');
            $this.parent().siblings('.current').addClass('active');
            $this.closest('label').next('i').remove();

            $this.closest('.form-group').addClass('has-error');
            setTimeout(function () {
                $this.closest('.form-group').removeClass('has-error');
            }, 2000);
        }
    });
});

// array input control
$('.ajax-form-dynamic .btn-danger').on('click', removeInput);

$('.ajax-form-dynamic .btn-success').on('click', function () {
    var container = $(this).closest('.ajax-form-dynamic');
//            var $inputs = container.find('input');
    var newForm = container.find('.form-group:first').clone(true);

    // reformat the input
    newForm.children('label').remove();
    newForm.children('.col-sm-9').addClass('col-sm-offset-3');
    var button = newForm.find('.btn-success');
    button.click(removeInput);
    button.removeClass('btn-success').addClass('btn-danger');
    newForm.find('.fa-plus-circle').removeClass('fa-plus-circle').addClass('fa-times-circle');

    // fixup the input field indexes
    var newInput = newForm.find('input');
    var inputs = container.find('input');
    inputs.each(function (index) {
        $(this).data('index', index);
    });
    newInput.val('');
    newInput.data('index', inputs.length);
    container.append(newForm);
});

function removeInput() {
    var $this = $(this);
    var input = $this.parent().prev('input');
    var key = input.attr('name');
    var index = input.data('index');

    var data = [];
    $("input[name='" + key + "']").each(function (i) {
        if (i != index) {
            data.push($(this).val());
        }
    });

    $.ajax({
        type: 'POST',
        url: settings_url,
        data: {
            type: 'settings-array',
            key: key,
            value: data
        },
        dataType: 'html',
        success: function () {
            $this.closest('.form-group').remove();

            $("input[name='" + key + "']").each(function (index) {
                $(this).data('index', index);
            });

        },
        error: function () {
            // show error
            console.log('delete error');
        }
    });
}
