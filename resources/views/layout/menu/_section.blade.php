<li class="menu">
    <a href="#submenu{{ $section->targetString }}" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
        <div class="">
            <i data-feather="{{ $section->icon }}"></i>
            <span>{{ $section->title }}</span>
        </div>
        <div>
            <i data-feather="chevron-right"></i>
        </div>
    </a>
    <ul class="collapse submenu list-unstyled" id="submenu{{ $section->targetString }}" data-parent="#accordionExample">
        @foreach ($section->entries as $entry)
            @include('layout.menu._link', ['entry' => $entry])
        @endforeach
    </ul>
</li>
