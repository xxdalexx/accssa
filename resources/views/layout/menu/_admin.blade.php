@role('admin')
    <li>
        <a href="#menu-admin" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false">
            <i class="ri-shield-user-line"></i>
            <span>Admin Tools</span>
            <i class="ri-arrow-right-s-line iq-arrow-right"></i>
        </a>
        <ul id="menu-admin" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
            @can('manage series')
            <li>
                <a href="{{ route('series.create') }}">
                    <i class="ri-add-box-line"></i>
                    <span>Create Series</span>
                </a>
            </li>
            @endcan
            @can('manage users')
            <li>
                <a href="{{ route('admin.users') }}">
                    <i class="ri-folder-user-line"></i>
                    <span>User Management</span>
                </a>
            </li>
            @endcan
            @can('manage drivers')
            <li>
                <a href="{{ route('admin.drivers') }}">
                    <i class="ri-roadster-fill"></i>
                    <span>Driver Management</span>
                </a>
            </li>
            @endcan
            <li>
                <a href="{{ route('admin.sgpToken') }}">
                    <i class="ri-window-line"></i>
                    <span>SGP API Token</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.neededTracks') }}">
                    <i class="ri-road-map-line"></i>
                    <span>Needed Tracks</span>
                </a>
            </li>
        </ul>
    </li>
@endrole
