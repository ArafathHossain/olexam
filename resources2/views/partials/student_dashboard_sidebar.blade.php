<div class="col-lg-3 col-md-3 p-0">
    <div class="dashboard-navbar">

        <div class="d-user-avater">
            <img src="{{ asset(''. auth()->user()->photo)}}" class="img-fluid avater" alt="">
            <h4>
                @auth
                {{ auth()->user()->name }}
                @endauth
            </h4>
            <span>Dhaka, Bangladesh</span>
        </div>

        <div class="d-navigation">
            <ul id="side-menu">
                {{-- <li class=" {{ request()->is('my-section/dashboard') ? 'active' : '' }}"><a
                        href="{{  route('student_dashboard') }}"><i class="ti-user"></i>Dashboard</a></li> --}}
                <li class="{{ request()->is('my-section/profile') ? 'active' : '' }}"><a
                        href="{{ route('my_profile') }}"><i class="ti-heart"></i>My Profile</a></li>
                <li class="{{ request()->is('my-section/saved_courses') ? 'active' : '' }}"><a
                        href="{{ route('saved_courses') }}"><i class="ti-heart"></i>Saved Courses</a></li>
                <li class="{{ request()->is('my-section/all_courses') ? 'active' : '' }}">
                    <a href="{{ route('all_courses') }}"><i class="ti-layers"></i>All Courses</a>
                </li>
                <!--<li class="{{ request()->is('my-section/course_stats') ? 'active' : '' }}">-->
                <!--    <a href="{{ route('course_stats') }}"><i class="ti-layers"></i>Courses Stats</a>-->
                <!--</li>-->
                <!--<li class="{{ request()->is('my-section/live_exams') ? 'active' : '' }}">-->
                <!--    <a href="{{ route('dashboard.live_exam') }}"><i class="ti-layers"></i>Live Exams</a>-->
                <!--</li>-->
                <li class="{{ request()->is('my-section/my_orders') ? 'active' : '' }}"><a
                        href="{{ route('my_orders') }}"><i class="ti-shopping-cart"></i>My Order</a></li>
                <li class="{{ request()->is('my-section/settings') ? 'active' : '' }}"><a
                        href="{{ route('settings') }}"><i class="ti-settings"></i>Settings</a></li>
                <!--                <li><a href="reviews.php"><i class="ti-comment-alt"></i>Reviews</a></li>-->
                <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"><i class=" ti-power-off"></i>Log Out</a></li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </ul>
        </div>

    </div>


</div>
