@extends('layouts.widget')

@section('content')
    @if ($type === 'horiz')
<table class="table table-hover">
    <tr>
        <th></th>
        <th><span class="text-muted">Total</span></th>
        <th><span class="text-success">Up</span></th>
        <th><span class="text-danger">Down</span></th>
        <th><span class="text-primary">Ignored</span></th>
        <th><span class="text-info">Disabled</span></th>
    </tr>
    <tr>
        <td><strong>Devices</strong></td>
        <td><span class="badge">{{ $count['devices']['total'] }}</span></td>
        <td><span class="badge bg-green">{{ $count['devices']['up'] }}</span></td>
        <td><span class="badge bg-red">{{ $count['devices']['down'] }}</span></td>
        <td><span class="badge bg-blue">{{ $count['devices']['ignored'] }}</span></td>
        <td><span class="badge bg-light-blue">{{ $count['devices']['disabled'] }}</span></td>
    </tr>
    <tr>
        <td><strong>Ports</strong></td>
        <td><span class="badge">{{ $count['ports']['total'] }}</span></td>
        <td><span class="badge bg-green">{{ $count['ports']['up'] }}</span></td>
        <td><span class="badge bg-red">{{ $count['ports']['down'] }}</span></td>
        <td><span class="badge bg-blue">{{ $count['ports']['ignored'] }}</span></td>
        <td><span class="badge bg-light-blue">{{ $count['ports']['disabled'] }}</span></td>
    </tr>
</table>
    @elseif ($type === 'vert')
    <table class="table table-hover">
        <tr>
            <th></th>
            <th><strong>Devices</strong></th>
            <th><strong>Ports</strong</th>
        </tr>
        <tr>
            <td><span class="text-success"><strong>Up</strong></span></td>
            <td><span class="badge bg-green">{{ $count['devices']['up'] }}</span></td>
            <td><span class="badge bg-green">{{ $count['ports']['up'] }}</span></td>
        </tr>
        <tr>
            <td><span class="text-danger"><strong>Down</strong></span></td>
            <td><span class="badge bg-red">{{ $count['devices']['down'] }}</span></td>
            <td><span class="badge bg-red">{{ $count['ports']['down'] }}</span></td>
        </tr>
        <tr>
            <td><span class="text-primary"><strong>Ignored</strong></span></td>
            <td><span class="badge bg-blue">{{ $count['devices']['ignored'] }}</span></td>
            <td><span class="badge bg-blue">{{ $count['ports']['ignored'] }}</span></td>
        </tr>
        <tr>
            <td><span class="text-info"><strong>Disabled</strong></span></td>
            <td><span class="badge bg-light-blue">{{ $count['devices']['disabled'] }}</span></td>
            <td><span class="badge bg-light-blue">{{ $count['ports']['disabled'] }}</span></td>
        </tr>
        <tr>
            <td><span class="text-muted"><strong>Total</strong></span></td>
            <td><span class="badge">{{ $count['devices']['total'] }}</span></td>
            <td><span class="badge">{{ $count['ports']['total'] }}</span></td>
        </tr>
    </table>
    @endif
@endsection

@section('scripts')
@endsection
