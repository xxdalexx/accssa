@role('admin')
    <li>
        <a href="#menu-admin" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false">
            <i class="ri-shield-user-line"></i>
            <span>Admin Tools</span>
            <i class="ri-arrow-right-s-line iq-arrow-right"></i>
        </a>
        <ul id="menu-admin" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
            <li>
                <a href="{{ route('series.create') }}">
                    <i class="ri-add-box-line"></i>
                    <span>Create Series</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users') }}">
                    <i class="ri-folder-user-line"></i>
                    <span>User Management</span>
                </a>
            </li>
        </ul>
    </li>
@endrole
