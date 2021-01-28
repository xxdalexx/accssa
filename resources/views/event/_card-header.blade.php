<div class="d-flex justify-content-between">
    <div>
        <h4>{{ $event->session_name }}</h4>
    </div>
    <div>
        <a href="{{ $event->sgpLink() }}" target="_blank">SGP Page</a>
        @if($event->replay_url)
         - <a href="{{ $event->replay_url }}" target="_blank">Replay</a>
        @endif
    </div>
</div>
