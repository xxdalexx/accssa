<li class="menu">
    <a href="#starter-kit" data-active="true" data-toggle="collapse" aria-expanded="true"
        class="dropdown-toggle">
        <div class="">
            <i data-feather="terminal"></i>
            <span>Administration</span>
        </div>
        <div>
            <i data-feather="chevron-right"></i>
        </div>
    </a>
    <ul class="submenu list-unstyled collapse show" id="starter-kit" data-parent="#accordionExample"
        style="">
        @foreach($menu->getAdminEntries() as $entry)
            @include('layout.menu._link', ['entry' => $entry])
        @endforeach
    </ul>
</li>
