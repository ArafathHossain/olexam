<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Bootstrap 4 Admin &amp; Dashboard Template">
    <meta name="author" content="Sumon Mia">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>OLM -Admin Panel</title>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('admin/assets/dist/img/favicon.png')}}">
    <!--Global Styles(used by all pages)-->
    <link href="{{ asset('admin/assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('admin/assets/plugins/metisMenu/metisMenu.min.css')}}" rel="stylesheet">
    <link href="{{ asset('admin/assets/plugins/fontawesome/css/all.min.css')}}" rel="stylesheet">
    <link href="{{ asset('admin/assets/plugins/typicons/src/typicons.min.css')}}" rel="stylesheet">
    <link href="{{ asset('admin/assets/plugins/themify-icons/themify-icons.min.css')}}" rel="stylesheet">
    <script>
        var token = "{{ csrf_token() }}";

    </script>
@yield('css')
<!--Start Your Custom Style Now-->
    <link href="{{ asset('admin/assets/dist/css/style.css')}}" rel="stylesheet">
    @yield('custom_css')
</head>

<body class="fixed">
<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="preloader">
            <div class="spinner-layer pl-green">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
        <p>Please wait...</p>
    </div>
</div>
<!-- #END# Page Loader -->
<div class="wrapper">
    <!-- Sidebar  -->
    <nav class="sidebar sidebar-bunker">
        <div class="sidebar-header">
            <!--<a href="index.html" class="logo"><span>bd</span>task</a>-->
            <!--<a href="index.html" class="logo"><img src="{{ asset('admin/assets/dist/img/logo.png')}}" alt=""></a>-->
            <a href="{{ route('home') }}"><h4><b>Admin Panel</b></h4></a>
        </div>
        <!--/.sidebar header-->
        <div class="profile-element d-flex align-items-center flex-shrink-0">
            <div class="avatar online">
                <img src="{{ asset(''.auth()->user()->photo ? auth()->user()->photo : 'images/user/user.png')}}"
                     class="img-fluid rounded-circle" alt="">
            </div>
            <div class="profile-text">
                <h6 class="m-0">{{ ucwords(auth()->user()->name) }}</h6>
                <span>{{ auth()->user()->email }}</span>

            </div>
        </div>
        <!--/.profile element-->
        <form class="search sidebar-form" action="index.html#" method="get">
            <div class="search__inner">
                <input type="text" class="search__text" placeholder="Search...">
                <i class="typcn typcn-zoom-outline search__helper" data-sa-action="search-close"></i>
            </div>
        </form>
        <!--/.search-->
        <div class="sidebar-body">
            <nav class="sidebar-nav">
                <ul class="metismenu">
                    <li class="nav-label">Main Menu</li>
                    <li class="{{ request()->is('home') ? "mm-active" : "" }}">
                        <a href="{{ route('home') }}">
                            <i class="typcn typcn-home-outline mr-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-label">Administration</li>
                    @if (auth()->user()->can('manage-user') || auth()->user()->can('manage-role'))

                        <li
                            class=" {{ request()->is('admin/users') || request()->is('admin/users/*') || request()->is('admin/roles') || request()->is('admin/roles/*') ? "mm-active" : "" }}">
                            <a class="has-arrow material-ripple" href="#">
                                <i class="typcn typcn-group-outline mr-2"></i>
                                User Management
                            </a>
                            <ul class="nav-second-level">
                                @can('manage-user')
                                    <li
                                        class=" {{ request()->is('admin/users') || request()->is('admin/users/*') ? "mm-active" : "" }}">
                                        <a href="{{ route('admin.users.index') }}">Users</a>
                                    </li>
                                    <li
                                        class=" {{ request()->is('admin/students') || request()->is('admin/students/*') ? "mm-active" : "" }}">
                                        <a href="{{ route('admin.students.index') }}">Students</a>
                                    </li>
                                @endcan
                                @can('manage-role')
                                    <li
                                        class=" {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? "mm-active" : "" }}">
                                        <a href="{{ route('admin.roles.index') }}">Roles</a>
                                    </li>
                                @endcan
                            </ul>

                        </li>
                    @endif
                    <li
                        class="{{ request()->is('admin/leaderboard')|| request()->is('admin/leaderboard/*') ? "mm-active" : "" }}">
                        <a href="{{ route('admin.leaderboard.index') }}">
                            <i class="typcn typcn-chart-bar mr-2"></i>
                            Leader Board
                        </a>
                    </li>
                    @can('manage-exam')
                        <li
                            class="{{ request()->is('admin/manage-exam')|| request()->is('admin/manage-exam/*') ? "mm-active" : "" }}">
                            <a href="{{ route('admin.manage.exam') }}">
                                <i class="typcn typcn-user mr-2"></i>
                                Manage Examiner
                            </a>
                        </li>
                    @endcan
                    @can('manage-result')
                        <li
                            class="{{ request()->is('admin/result-manage')|| request()->is('admin/result-manage/*') ? "mm-active" : "" }}">
                            <a href="{{ route('admin.all.exam.set') }}">
                                <i class="typcn typcn-clipboard mr-2"></i>
                                Manage Result
                            </a>
                        </li>
                    @endcan
                    @can('manage-mcq')
                        <li
                            class="{{ request()->is('admin/main-mcqs')|| request()->is('admin/main-mcqs/*') ? "mm-active" : "" }}">
                            <a href="{{ route('admin.main-mcqs.index') }}">
                                <i class="typcn typcn-pen mr-2"></i>
                                All MCQ
                            </a>
                        </li>
                    @endcan
                    @can('manage-subject')
                        <li
                            class="{{ request()->is('admin/subjects')|| request()->is('admin/subjects/*') ? "mm-active" : "" }}">
                            <a href="{{ route('admin.subjects.index') }}">
                                <i class="typcn typcn-book mr-2"></i>
                                All Subjects
                            </a>
                        </li>
                    @endcan
                    @can('manage-class')
                        <li
                            class="{{ request()->is('admin/classes')|| request()->is('admin/classes/*') ? "mm-active" : "" }}">
                            <a href="{{ route('admin.classes.index') }}">
                                <i class="typcn typcn-flow-merge mr-2"></i>
                                All Classes
                            </a>
                        </li>
                    @endcan
                    @can('manage-package')
                        <li
                            class="{{ request()->is('admin/packages')|| request()->is('admin/packages/*') ? "mm-active" : "" }}">
                            <a href="{{ route('admin.packages.index') }}">
                                <i class="typcn typcn-tree mr-2"></i>
                                All Packages
                            </a>
                        </li>
                    @endcan
                    @can('manage-live-exam')
                        <li
                            class="{{ request()->is('admin/live-exams')|| request()->is('admin/live-exams/*') ? "mm-active" : "" }}">
                            <a href="{{ route('admin.live-exams.index') }}">
                                <i class="typcn typcn-waves mr-2"></i>
                                All Live Exams
                            </a>
                        </li>
                    @endcan

                    <li class="">
                        <a class="has-arrow material-ripple" href="#">
                            <i class="typcn typcn-group-outline mr-2"></i>
                            Website Management
                        </a>
                        <ul class="nav-second-level">
                            @can('manage-page')
                                <li
                                    class="{{ request()->is('admin/pages')|| request()->is('admin/pages/*') ? "mm-active" : "" }}">
                                    <a href="{{ route('admin.pages.index') }}">
                                        <i class="typcn typcn-feather mr-2"></i>
                                        All Pages
                                    </a>
                                </li>
                            @endcan
                            @can('manage-about-page')
                                <li
                                    class="{{ request()->is('admin/abouts')|| request()->is('admin/abouts/*') ? "mm-active" : "" }}">
                                    <a href="{{ route('admin.abouts.index') }}">
                                        <i class="typcn typcn-point-of-interest-outline mr-2"></i>
                                        About
                                    </a>
                                </li>
                            @endcan
                            @can('manage-setting')
                                <li
                                    class="{{ request()->is('admin/home_page')|| request()->is('admin/home_page/*') ? "mm-active" : "" }}">
                                    <a href="{{ route('admin.get.home_page') }}">
                                        <i class="typcn typcn-point-of-interest-outline mr-2"></i>
                                        Home Page
                                    </a>
                                </li>
                            @endcan
                            @can('manage-faq-page')
                                <li
                                    class="{{ request()->is('admin/faqs')|| request()->is('admin/faqs/*') ? "mm-active" : "" }}">
                                    <a href="{{ route('admin.faqs.index') }}">
                                        <i class="typcn typcn-point-of-interest-outline mr-2"></i>
                                        Faqs
                                    </a>
                                </li>
                            @endcan
                            @can('manage-footer')
                                <li
                                    class="{{ request()->is('admin/footers')|| request()->is('admin/footers/*') ? "mm-active" : "" }}">
                                    <a href="{{ route('admin.footers.index') }}">
                                        <i class="typcn typcn-th-small mr-2"></i>
                                        Footer Menu
                                    </a>
                                </li>
                            @endcan
                            @can('manage-coupon')
                                <li
                                    class="{{ request()->is('admin/coupons')|| request()->is('admin/coupons/*') ? "mm-active" : "" }}">
                                    <a href="{{ route('admin.coupons.index') }}">
                                        <i class="typcn typcn-point-of-interest-outline mr-2"></i>
                                        Coupons
                                    </a>
                                </li>
                            @endcan
                            @can('manage-setting')
                                <li
                                    class="{{ request()->is('admin/setting')|| request()->is('admin/setting/*') ? "mm-active" : "" }}">
                                    <a href="{{ route('admin.get.setting') }}">
                                        <i class="typcn typcn-point-of-interest-outline mr-2"></i>
                                        Setting
                                    </a>
                                </li>
                            @endcan
                        </ul>

                    </li>
                </ul>
            </nav>
        </div><!-- sidebar-body -->
    </nav>
    <!-- Page Content  -->
    <div class="content-wrapper" id="app">
        <div class="main-content">
            <nav class="navbar-custom-menu navbar navbar-expand-lg m-0">
                <div class="sidebar-toggle-icon" id="sidebarCollapse">
                    sidebar toggle<span></span>
                </div>
                <!--/.sidebar toggle icon-->
                <div class="d-flex flex-grow-1">
                    <ul class="navbar-nav flex-row align-items-center ml-auto">
                        <!--<li class="nav-item dropdown quick-actions">-->
                        <!--    <a class="nav-link dropdown-toggle" href="index.html#" data-toggle="dropdown">-->
                        <!--        <i class="typcn typcn-th-large-outline"></i>-->
                        <!--    </a>-->
                        <!--    <div class="dropdown-menu dropdown-menu-right">-->
                        <!--        <div class="nav-grid-row row">-->
                        <!--            <a href="index.html#" class="icon-menu-item col-4">-->
                        <!--                <i class="typcn typcn-cog-outline d-block"></i>-->
                        <!--                <span>Settings</span>-->
                        <!--            </a>-->
                        <!--            <a href="index.html#" class="icon-menu-item col-4">-->
                        <!--                <i class="typcn typcn-group-outline d-block"></i>-->
                        <!--                <span>Users</span>-->
                        <!--            </a>-->
                        <!--            <a href="index.html#" class="icon-menu-item col-4">-->
                        <!--                <i class="typcn typcn-puzzle-outline d-block"></i>-->
                        <!--                <span>Components</span>-->
                        <!--            </a>-->
                        <!--            <a href="index.html#" class="icon-menu-item col-4">-->
                        <!--                <i class="typcn typcn-chart-bar-outline d-block"></i>-->
                        <!--                <span>Profits</span>-->
                        <!--            </a>-->
                        <!--            <a href="index.html#" class="icon-menu-item col-4">-->
                        <!--                <i class="typcn typcn-time d-block"></i>-->
                        <!--                <span>New Event</span>-->
                        <!--            </a>-->
                        <!--            <a href="index.html#" class="icon-menu-item col-4">-->
                        <!--                <i class="typcn typcn-edit d-block"></i>-->
                        <!--                <span>Tasks</span>-->
                        <!--            </a>-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--</li>-->
                        <!--/.dropdown-->
                        <!--<li class="nav-item">-->
                        <!--    <a class="nav-link" href="chat.html"><i class="typcn typcn-messages"></i></a>-->
                        <!--</li>-->
                        <!--<li class="nav-item dropdown notification">-->
                        <!--    <a class="nav-link dropdown-toggle badge-dot" href="index.html#" data-toggle="dropdown">-->
                        <!--        <i class="typcn typcn-bell"></i>-->
                        <!--    </a>-->
                        <!--    <div class="dropdown-menu dropdown-menu-right">-->
                        <!--        <h6 class="notification-title">Notifications</h6>-->
                        <!--        <p class="notification-text">You have 2 unread notification</p>-->
                        <!--        <div class="notification-list">-->
                        <!--            <div class="media new">-->
                        <!--                <div class="img-user"><img-->
                        <!--                        src="{{ asset('admin/assets/dist/img/avatar.png')}}" alt=""></div>-->
                        <!--                <div class="media-body">-->
                        <!--                    <h6>Congratulate <strong>Socrates Itumay</strong> for work anniversaries-->
                        <!--                    </h6>-->
                        <!--                    <span>Mar 15 12:32pm</span>-->
                        <!--                </div>-->
                        <!--            </div>-->
                                    <!--/.media -->
                        <!--            <div class="media new">-->
                        <!--                <div class="img-user online"><img-->
                        <!--                        src="{{ asset('admin/assets/dist/img/avatar2.png')}}" alt=""></div>-->
                        <!--                <div class="media-body">-->
                        <!--                    <h6><strong>Joyce Chua</strong> just created a new blog post</h6>-->
                        <!--                    <span>Mar 13 04:16am</span>-->
                        <!--                </div>-->
                        <!--            </div>-->
                                    <!--/.media -->
                        <!--            <div class="media">-->
                        <!--                <div class="img-user"><img-->
                        <!--                        src="{{ asset('admin/assets/dist/img/avatar3.png')}}" alt=""></div>-->
                        <!--                <div class="media-body">-->
                        <!--                    <h6><strong>Althea Cabardo</strong> just created a new blog post</h6>-->
                        <!--                    <span>Mar 13 02:56am</span>-->
                        <!--                </div>-->
                        <!--            </div>-->
                                    <!--/.media -->
                        <!--            <div class="media">-->
                        <!--                <div class="img-user"><img-->
                        <!--                        src="{{ asset('admin/assets/dist/img/avatar4.png')}}" alt=""></div>-->
                        <!--                <div class="media-body">-->
                        <!--                    <h6><strong>Adrian Monino</strong> added new comment on your photo</h6>-->
                        <!--                    <span>Mar 12 10:40pm</span>-->
                        <!--                </div>-->
                        <!--            </div>-->
                                    <!--/.media -->
                        <!--        </div>-->
                                <!--/.notification -->
                        <!--        <div class="dropdown-footer"><a href="index.html">View All Notifications</a></div>-->
                        <!--    </div>-->
                            <!--/.dropdown-menu -->
                        <!--</li>-->
                        <!--/.dropdown-->
                        <li class="nav-item dropdown user-menu">
                            <a class="nav-link dropdown-toggle" href="index.html#" data-toggle="dropdown">
                            <!--<img src="{{ asset('admin/assets/dist/img/user2-160x160.png')}}" alt="">-->
                                <!--<i class="typcn typcn-user-add-outline"></i>-->
                                <i class="typcn typcn-key-outline"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="dropdown-header d-sm-none">
                                    <a href="index.html" class="header-arrow"><i
                                            class="icon ion-md-arrow-back"></i></a>
                                </div>
                                <div class="user-header">
                                    <div class="img-user">
                                        <img
                                            src="{{ asset(''. auth()->user()->photo ? auth()->user()->photo : 'images/user/user.png'  )}}"
                                            alt="">
                                    </div><!-- img-user -->
                                    <h6>{{ ucwords(auth()->user()->name) }}</h6>
                                    <span>
                                            <a href="#" class="__cf_email__"> {{ auth()->user()->email }}</a>
                                        </span>
                                </div><!-- user-header -->
                                <!--<a href="index.html" class="dropdown-item"><i class="typcn typcn-user-outline"></i>-->
                                <!--    My Profile</a>-->
                                <!--<a href="index.html" class="dropdown-item"><i class="typcn typcn-edit"></i> Edit-->
                                <!--    Profile</a>-->
                                <!--<a href="index.html" class="dropdown-item"><i class="typcn typcn-arrow-shuffle"></i>-->
                                <!--    Activity Logs</a>-->
                                <!--<a href="index.html" class="dropdown-item"><i class="typcn typcn-cog-outline"></i>-->
                                <!--    Account Settings</a>-->
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit();">
                                    <i class="typcn typcn-key-outline"></i>
                                    {{ __('Sign Out') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>

                            </div>
                            <!--/.dropdown-menu -->
                        </li>
                    </ul>
                    <!--/.navbar nav-->
                    <div class="nav-clock">
                        <div class="time">
                            <span class="time-hours"></span>
                            <span class="time-min"></span>
                            <span class="time-sec"></span>
                        </div>
                    </div><!-- nav-clock -->
                </div>
            </nav>
            <!--/.navbar-->
            <!--Content Header (Page header)-->
        @yield('page_header')
        <!--/.Content Header (Page header)-->
            <div class="body-content">
                @yield('content')
            </div>
            <!--/.body content-->
        </div>
        <!--/.main content-->
        <footer class="footer-content">
            <div class="footer-text d-flex align-items-center justify-content-between">
                <div class="copy">© 2020 OLM - Online Live MCQ.</div>
                <div class="credit">Developed By:
                    <a href="linkedin.com/in/nayeemsweb/" target="_blank">Nayeem Rahman</a>
                </div>
            </div>
        </footer>
        <!--/.footer content-->
        <div class="overlay"></div>
    </div>
    <!--/.wrapper-->
</div>
<!--Global script(used by all pages)-->
{{-- <script data-cfasync="false" src="{{ asset('admin/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js')}}">
</script> --}}
<script src="{{ asset('js/app.js')}}"></script>
{{-- <script src="{{ asset('admin/assets/plugins/jQuery/jquery-3.4.1.min.js')}}"></script> --}}
{{-- <script src="{{ asset('admin/assets/dist/js/popper.min.js')}}"></script>
<script src="{{ asset('admin/assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script> --}}
<script src="{{ asset('admin/assets/plugins/metisMenu/metisMenu.min.js')}}"></script>
<script src="{{ asset('admin/assets/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js')}}"></script>
@yield('js')
<!--Page Scripts(used by all page)-->
<script src="{{ asset('admin/assets/dist/js/sidebar.js')}}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.form-control').on('change, keyup', function () {
        if ($(this).val() != '') {
            $(this).removeClass('is-invalid');
            $(this).parent().find('.text-danger').addClass('d-none');
        }
    });
    $('select.form-control').on('change', function () {
        if ($(this).val() != '') {
            $(this).removeClass('is-invalid');
            $(this).parent().find('.text-danger').addClass('d-none');
        }
    });

</script>
@yield('custom_js')
</body>

</html>
