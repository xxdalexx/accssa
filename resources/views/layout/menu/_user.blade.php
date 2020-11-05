@if(Auth::check())
<li>
    <a href="#menu-user" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false">
        <i class="ri-user-line"></i>
        <span>Your Stuff</span>
        <i class="ri-arrow-right-s-line iq-arrow-right"></i>
    </a>
    <ul id="menu-user" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
        <li>
            <a href="{{ route('user.show') }}">
                <i class="ri-profile-line"></i>
                <span>Profile</span>
            </a>
        </li>
    </ul>
</li>
@endif
