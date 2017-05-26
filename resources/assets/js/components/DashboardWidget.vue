<template>
    <div class="grid-stack-item" :data-gs-width="widget.size_x" :data-gs-height="widget.size_y">
        <div class="grid-stack-item-content box box-primary box-solid">
            <div class="box-header with-border draggable"><h3 class="box-title"> {{ widget.title }} </h3>
                <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool">
                    <i class="fa fa-wrench"></i></button>
                <button type="button" class="btn btn-box-tool"><i class="fa fa-trash"></i></button>
                </div></div>
            <div class="box-body">
                {{ widget.widget_id }}
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['widget']
    }
</script>
