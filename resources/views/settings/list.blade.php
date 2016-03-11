@extends('layouts.app')

@section('title', 'Settings')

@section('content')
    <div class="container">
        <pre>
{{ print_r($settings) }}
        </pre>
    </div>
@endsection
