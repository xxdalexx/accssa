@auth
    @foreach(App\Models\Series::all() as $series)
        <li>
            <a href="#series{{ $series->id }}" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false">
                <i class="ri-list-check-2"></i>
                <span>{{ $series->name }}</span>
                <i class="ri-arrow-right-s-line iq-arrow-right"></i>
            </a>
            <ul id="series{{ $series->id }}" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                <li>
                    <a href="{{ $series->link() }}">
                        <i class="ri-list-settings-line"></i>
                        Standings
                    </a>
                </li>
            </ul>
            @foreach($series->events as $event)
            <ul id="series{{ $series->id }}" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                <li>
                    <a href="{{ $event->link() }}">
                        <i class="ri-roadster-fill"></i>
                        {{ $event->session_name }}
                    </a>
                </li>
            </ul>
            @endforeach
        </li>
    @endforeach
@endauth
