<script type="text/javascript">
    $( document ).on('click', '.showModal', function(){
        var modalTitle = $(this).attr('data-modal-title');
        $('#modalTitle').text(modalTitle);

        var content = $('#modalContent');
        content.html('<div style="text-align:center"><i class="fa fa-spin fa-spinner"></i> Loading...</div>');

        var footer = $('#modalFooter');
        footer.find('.modalFooterContent').remove();

        $.ajax({
            url: $(this).attr('data-href'),
            dataType: 'html',
            success:function(data) {
                content.html(data);
//                var submit = content.find('input[type=submit].modalFooterContent');
                //TODO submit form?
                footer.prepend( content.find('.modalFooterContent') );
            },
            error: function(data) {
                toastr.error('Could not load dialog content');
                $('#generalModal').modal('hide');
            }
        });
    });

    $(document).on('click', '.modalSave', function (e) {
        e.preventDefault();

        var form = $(this).closest('form');

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
                var errors = $.parseJSON(data.responseText);
                form.find('.help-block').empty();
                $.each(errors, function (field, text) {
                    $('input[name ="' + field + '"]').parent().find('.help-block').text(text);
                });
            }
        });

        return false;
    });

</script>
