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
</script>
