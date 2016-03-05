@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<div class="row">
    <div class="col-md-12">
        <a class="btn btn-primary margin-bottom" href="{{ url('notifications/'.$page) }}">Show{{ $button }}</a>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <ul class="timeline">
            @foreach ($notifications as $notification)
            <li id="{{ $notification->notifications_id }}">
                <i class="fa fa-envelope bg-@if ($notification->key == 'sticky')yellow @else{{ $bg }} @endif"></i>
                <div class="timeline-item">
                    <span class="time"><i class="fa fa-clock-o"></i> {{ $notification->datetime }}</span>
                    <h3 class="timeline-header">{{ $notification->title }}</h3>
                    <div class="timeline-body">
                        {{ $notification->body }}
                    </div>
                    <div class="timeline-footer">
                        @if ($type === 'archive')
                        <a class="btn btn-danger btn-xs notification" id="read" data-id="{{ $notification->notifications_id }}" data-action="unread"><i class="fa fa-eye"></i> Mark as unread</a>
                        @else
                            @if ($notification->key === 'sticky')
                            <a class="btn btn-primary btn-xs notification" id="unsticky" data-id="{{ $notification->notifications_id }}" data-action="unsticky"><i class="fa fa-bell-o"></i> Un-Sticky</a>
                            @else
                            <a class="btn btn-primary btn-xs notification" id="sticky" data-id="{{ $notification->notifications_id }}" data-action="sticky"><i class="fa fa-bell-o"></i> Sticky</a>
                            @endif
                        <a class="btn btn-danger btn-xs notification" id="read" data-id="{{ $notification->notifications_id }}" data-action="read"><i class="fa fa-eye"></i> Mark as read</a>
                        @endif
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn-primary margin-bottom" href="{{ url('notifications/'.$page) }}">Show{{ $button }}</a>
    </div>
</div>
@endsection
@section('scripts')
    <script src="{{ url('js/util.js') }}"></script>
    <script>
        $.Util.markNotification('{{url('notifications')}}');
    </script>
@endsection
