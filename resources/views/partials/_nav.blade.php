<!-- navigation panel -->
<nav class="navbar navbar-default navbar-fixed-top nav-transparent overlay-nav sticky-nav nav-border-bottom" role="navigation">
    <div class="container">
        <div class="row">
            <!-- logo -->
            <div class="col-md-2 pull-left">
                <a class="logo-light" href="{{ route('index.index') }}">
                    <img alt="" src="{{ asset('images/logo.png') }}" class="logo" />
                </a>
                <a class="logo-dark" href="{{ route('index.index') }}">
                    <img alt="" src="{{ asset('images/logo.png') }}" class="logo" />
                </a>
            </div>
            <!-- end logo -->
            <!-- toggle navigation -->
            <div class="navbar-header col-sm-8 col-xs-2 pull-right">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <!-- toggle navigation end -->
            <!-- main menu -->
            <div class="col-md-9 no-padding-right accordion-menu text-right">
                <div class="navbar-collapse collapse">
                    <ul id="accordion" class="nav navbar-nav navbar-right panel-group">
                        <li>
                            <a href="{{ route('index.index') }}" class="inner-link">Home</a>
                        </li>
                        
                        <li>
                            <a href="{{ route('index.about') }}" class="inner-link">About Us</a>
                        </li>
                        
                        {{-- <li class="dropdown panel simple-dropdown">
                            <a href="#nav_archive" class="dropdown-toggle collapsed" data-toggle="collapse" data-parent="#accordion" data-hover="dropdown">
                                Archive ▽
                            </a>
                            <ul id="nav_archive" class="dropdown-menu panel-collapse collapse" role="menu">
                                <li>
                                    <a href="{{ route('index.publications') }}"><i class="icon-newspaper i-plain"></i> Publications</a>
                                </li>
                                <li>
                                    <a href="{{ route('index.disasterdata') }}"><i class="icon-cloud i-plain"></i> Data</a>
                                </li>
                            </ul>
                        </li> --}}
                        <li>
                            <a href="{{ route('index.contact') }}">Contact</a>
                        </li>
                        {{-- <li class="dropdown panel simple-dropdown">
                            <a href="#others_dropdown" class="dropdown-toggle collapsed" data-toggle="collapse" data-parent="#accordion" data-hover="dropdown">Others ▽
                            </a>
                            <ul id="others_dropdown" class="dropdown-menu panel-collapse collapse" role="menu">
                                <li>
                                    <a href="{{ route('index.news') }}"><i class="icon-newspaper i-plain"></i> News</a>
                                </li>
                                <li>
                                    <a href="{{ route('index.events') }}"><i class="icon-megaphone i-plain"></i> Events</a>
                                </li>
                                <li>
                                    <a href="{{ route('index.gallery') }}"><i class="icon-pictures i-plain"></i> Photo Gallery</a>
                                </li>
                            </ul>
                        </li> --}}
                        @if(Auth::check())
                        <li class="dropdown panel simple-dropdown">
                            <a href="#nav_auth_user" class="dropdown-toggle collapsed" data-toggle="collapse" data-parent="#accordion" data-hover="dropdown">
                                @php
                                    $nav_user_name = explode(' ', Auth::user()->name);
                                    $last_name = array_pop($nav_user_name);
                                @endphp
                                {{ $last_name }} ▽
                            </a>
                            <!-- sub menu single -->
                            <!-- sub menu item  -->
                            <ul id="nav_auth_user" class="dropdown-menu panel-collapse collapse" role="menu">
                                <li>
                                    <a href="{{ route('dashboard.index') }}"><i class="icon-speedometer i-plain"></i> Dashboard</a>
                                </li>
                                {{-- <li>
                                    <a href="{{ route('index.profile', Auth::user()->unique_key) }}"><i class="icon-profile-male i-plain"></i> Profile</a>
                                </li> --}}
                                <li>
                                    <a href="{{ url(config('adminlte.logout_url', 'auth/logout')) }}"><i class="icon-key i-plain"></i> Logout</a>
                                </li>
                            </ul>
                        </li>
                        @else
                        <li>
                            <a href="{{ url('login') }}" class="inner-link">Login</a>
                        </li>
                        @endif
                        <!-- end menu item -->
                    </ul>
                </div>
            </div>
            <!-- end main menu -->
        </div>
    </div>
</nav>
<!--end navigation panel -->