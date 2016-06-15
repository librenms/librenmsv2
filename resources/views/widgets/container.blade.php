<div id="'+data.user_widget_id+'" data-widget_id="'+data.widget_id+'" data-refresh="'+data.refresh+'">
    <div class=" box box-primary box-solid">
        <div class="box-header with-border draggable"><h3 class="box-title">' + settings.widget_title + '</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool edit-widget" data-id="' + data.user_widget_id + '" data-widget-name="' + settings.widget + '"
                        onClick="$.Dashboard.editWidget(this)"><i class="fa fa-wrench"></i></button>
                <button type="button" class="btn btn-box-tool remove-widget" data-id="' + data.user_widget_id + '" onClick="$.Dashboard.removeWidget(this)"><i
                            class="fa fa-trash"></i></button>
            </div>
        </div>
        <div class="box-body grid-stack-item-content">
            @yield('widgetcontent')
        </div>
    </div>
</div>