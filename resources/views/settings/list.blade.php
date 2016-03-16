@extends('layouts.app')

@section('title', 'Settings')

@section('content')

    @include('settings.sections.snmp')

    <div class="container">
        <pre>
{{ print_r($settings, 1) }}
        </pre>
    </div>
@endsection
