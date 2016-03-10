@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <div class="row">
        <div class="grid-stack">
            <div class="grid-stack-item" data-gs-x="0" data-gs-y="0" data-gs-width="4" data-gs-height="2">
                <div class="grid-stack-item-content">
                    <div class="box box-success box-solid">
                        <div class="box-header with-border draggable">
                            <h3 class="box-title">Expandable</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            dasd
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid-stack-item" data-gs-x="4" data-gs-y="0" data-gs-width="4" data-gs-height="4">
                <div class="grid-stack-item-content">
                    <div class="box box-success box-solid">
                        <div class="box-header with-border draggable">
                            <h3 class="box-title">Expandable</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            dasd
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
