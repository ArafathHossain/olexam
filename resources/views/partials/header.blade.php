        <!-- ============================================================== -->
        <!-- Top header  -->
        <!-- ============================================================== -->
        <!-- Start Navigation -->
        <div class="header header-light">
            <div class="container">
                <nav id="navigation" class="navigation navigation-landscape">
                    <div class="nav-header">
                        <a class="nav-brand" href="{{ url('/') }}">
                            <img src="/{{ site_setting('logo', 'images/logo.png') }}" class="logo" alt="" />
                        </a>
                        <div class="nav-toggle"></div>
                    </div>
                    <div class="nav-menus-wrapper" style="transition-property: none;">
                        <ul class="nav-menu">

                            <li class="{{ request()->is('/') ? 'active' : '' }}"><a href="{{ url('/') }}">Home<span class="submenu-indicator"></span></a>

                            </li>
                            <li class="{{ request()->is('about-us') ? 'active' : '' }}"><a href="{{ route('about') }}">About Us<span
                                        class="submenu-indicator"></span></a>
                            </li>
                            <li class="{{ request()->is('classes') || request()->is('classes/*') ? 'active' : '' }}"><a href="#">Classes<span class="submenu-indicator"></span></a>
                                <ul class="nav-dropdown nav-submenu classes">
                                    <div class="row">
                                        @php
                                        // $classes = App\Models\StudentClass::all();
                                        $number = 1;
                                        @endphp
                                        @foreach ($classes as $class)
                                        <div class="col-lg-4">
                                            <li>
                                                <a href="{{ route('classes', $class->slug) }}">{{ word_view($class->name) }}</a>
                                            </li>
                                        </div>
                                        @php
                                        $number++;
                                        @endphp
                                        @endforeach

                                    </div>
                                </ul>
                            </li>

                            <li class="{{ request()->is('package') || request()->is('package/*') ? 'active' : '' }}">
                                @php
                                $id = (auth()->check() && auth()->user()->grad != '' ) ? auth()->user()->grad :
                                App\Models\StudentClass::all()->random()->id;
                                @endphp
                                <a href="{{  route('package', 'cls_=' . $id ) }}">Packages<span
                                        class="submenu-indicator"></span></a>
                            </li>
                            
                            <li class="{{ request()->is('contact') ? 'active' : '' }}"><a href="{{ route('contact') }}">Contact</a></li>
                            <li class="{{ request()->is('faqs') ? 'active' : '' }}"><a href="{{ route('faqs') }}">FAQs</a></li>
                            <li class="{{ request()->is('leadboard') ? 'active' : '' }}"><a href="{{ route('leadboard') }}">Leadboard</a></li>
                            <li class="{{ request()->is('live/exam') ? 'active' : '' }}"><a href="{{ route('live.exam.page') }}" class="live">Live Exam</a></li>

                        </ul>

                        <ul class="nav-menu nav-menu-social align-to-right">
                            @guest
                            <li class="login_click light">
                                <a href="#" data-toggle="modal" data-target="#login">Login</a>
                            </li>
                            <li class="login_click theme-bg">
                                <a href="#" data-toggle="modal" data-target="#signup">Register</a>
                            </li>
                            @else

                            <li class="login_click theme-bg">
                                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('header-logout-form').submit();">Logout</a>
                            </li>
                            <li class="login_click theme-bg">
                                <a href="{{ route('my_profile') }}">Dashboard</a>
                            </li>
                            <form id="header-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            @endguest
                        </ul>

                    </div>
                </nav>
            </div>
        </div>
        <!-- End Navigation -->
        <!-- ============================================================== -->
        <!-- Top header  -->
        <!-- ============================================================== -->
