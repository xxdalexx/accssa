        <!-- Sidebar  -->
        <div class="iq-sidebar">
            <div class="iq-sidebar-logo d-flex justify-content-between">
                <a href="index.html">
                    <img src="{{ asset('images/logo.gif') }}" class="img-fluid" alt="">
                    <span>SGP+</span>
                </a>
                <div class="iq-menu-bt align-self-center">
                    <div class="wrapper-menu">
                        <div class="line-menu half start"></div>
                        <div class="line-menu"></div>
                        <div class="line-menu half end"></div>
                    </div>
                </div>
            </div>
            <div id="sidebar-scrollbar">
                <nav class="iq-sidebar-menu">
                    <ul id="iq-sidebar-toggle" class="iq-menu">
                        @foreach(App\Models\Series::all() as $series)
                        <li>
                            <a href="#series{{ $series->id }}" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false">
                                <i class="ri-record-circle-line"></i>
                                <span>{{ $series->name }}</span>
                                <i class="ri-arrow-right-s-line iq-arrow-right"></i>
                            </a>
                            <ul id="series{{ $series->id }}" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                                <li>
                                    <a href="{{ $series->link() }}">
                                        <i class="ri-record-circle-line"></i>
                                        Standings
                                    </a>
                                </li>
                            </ul>
                            <ul id="series{{ $series->id }}" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                                <li>
                                    <a href="{{ $series->linkDropOne() }}">
                                        <i class="ri-record-circle-line"></i>
                                        Standings Drop One
                                    </a>
                                </li>
                            </ul>
                            @foreach($series->events as $event)
                            <ul id="series{{ $series->id }}" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                                <li>
                                    <a href="{{ $event->link() }}">
                                        <i class="ri-record-circle-line"></i>
                                        {{ $event->session_name }}
                                    </a>
                                </li>
                            </ul>
                            @endforeach
                        </li>
                        @endforeach
                        <li>
                            <a href="#menu-level" class="iq-waves-effect collapsed" data-toggle="collapse"
                                aria-expanded="false"><i class="ri-record-circle-line"></i><span>Menu Level</span><i
                                    class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                            <ul id="menu-level" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                                <li><a href="#"><i class="ri-record-circle-line"></i>Menu 1</a></li>
                                <li><a href="#"><i class="ri-record-circle-line"></i>Menu 2</a>
                                <li>
                                    <a href="#sub-menu" class="iq-waves-effect collapsed" data-toggle="collapse"
                                        aria-expanded="false"><i class="ri-play-circle-line"></i><span>Sub-menu</span><i
                                            class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                                    <ul id="sub-menu" class="iq-submenu iq-submenu-data collapse">
                                        <li><a href="#"><i class="ri-record-circle-line"></i>Sub-menu 1</a></li>
                                        <li><a href="#"><i class="ri-record-circle-line"></i>Sub-menu 2</a></li>
                                        <li><a href="#"><i class="ri-record-circle-line"></i>Sub-menu 3</a></li>
                                    </ul>
                                </li>
                        </li>
                        <li><a href="#"><i class="ri-record-circle-line"></i>Menu 3</a></li>
                        <li><a href="#"><i class="ri-record-circle-line"></i>Menu 4</a></li>
                    </ul>
                    </li>
                    </ul>
                </nav>
                <div class="p-3"></div>
            </div>
        </div>
