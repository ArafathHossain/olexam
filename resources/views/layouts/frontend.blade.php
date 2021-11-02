<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="author" content="sumon mia" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:title" content="OLM - {{ site_setting('title') }}">
    <link rel="shortcut icon" href="/{{ site_setting('favicon', 'images/favicon.png') }}" type="image/x-icon">
    @php
        $title = site_setting('title', 'Online Live MCQ Exam Online');
    @endphp
    <title>OLM - @yield("title", "$title")</title>
    {{-- Custom css for page --}}
    @yield('css')
    <!-- Custom CSS -->
    <link href="{{ asset('css/price-filter/tailwind.min.css')}}" rel="stylesheet">
    <link href="{{ asset('css/price-filter/style.css')}}" rel="stylesheet">
{{--    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css')}}" rel="stylesheet">
    <!-- Custom Color Option -->
    <link href="{{ asset('css/colors.css')}}" rel="stylesheet">
    {{-- Custom css for page --}}
    @yield('custom_css')
    @paddleJS
</head>

<body class="red-skin">

    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div id="preloader">
        <div class="preloader"><span></span><span></span></div>
    </div>


    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <div class="clearfix"></div>
        @include('partials.header')
        @yield('content')

        @include('partials.newsletter')
        @include('partials.footer')


        <!-- Log In Modal -->
        <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="registermodal"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered login-pop-form" role="document">
                <div class="modal-content" id="registermodal">
                    <span class="mod-close" data-dismiss="modal" aria-hidden="true"><i class="ti-close"></i></span>
                    <div class="modal-body">
                        <h4 class="modal-header-title">Log In</h4>
                        <div class="login-form">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group">
                                    <label>E-Mail Address</label>
                                    <input type="text" class="form-control @error('email') is-invalid @enderror"
                                        placeholder="Username" name="email" value="{{ old('email') }}">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        placeholder="* * * * * * *" name="password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-md full-width pop-login">Login</button>
                                </div>
                                <p class="text-center">Or</p>
                                <div class="form-group">
                                    <a href="{{ route('google') }}" class="btn btn-md full-width pop-login">Login with
                                        Google</a>
                                </div>
                            </form>
                        </div>

                        <div class="social-login mb-3">
                            <ul>
                                <li>
                                    <input id="reg" class="checkbox-custom" type="checkbox" name="remember"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <label for="reg" class="checkbox-custom-label">Save Password</label>
                                </li>
                                </li>
                                @if (Route::has('password.request'))
                                <li><a href="{{ route('password.request') }}" class="theme-cl">Forget Password?</a></li>
                                @endif
                            </ul>
                        </div>

                        <div class="text-center">
                            <p class="mt-2">Haven't Any Account? <a href="register.php" class="link">Click here</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal -->

        <!-- Sign Up Modal -->
        <div class="modal fade" id="signup" tabindex="-1" role="dialog" aria-labelledby="sign-up" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered login-pop-form" role="document">
                <div class="modal-content" id="sign-up">
                    <span class="mod-close" data-dismiss="modal" aria-hidden="true"><i class="ti-close"></i></span>
                    <div class="modal-body">
                        <h4 class="modal-header-title">Register</h4>
                        <div class="login-form">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="form-group">
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Full Name">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <input type="email" class="form-control  @error('email') is-invalid @enderror "
                                        name="email" placeholder="Email">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                {{-- <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Username">
                                </div> --}}

                                <div class="form-group">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        name="password" placeholder="Password (Minimum 6 Characters)">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        name="password_confirmation" placeholder="Password Confirm">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    {{-- <label for="grad">Grade/Class</label> --}}
                                    <select id="grad" class="form-control @error('grad') is-invalid @enderror" name="grad">
                                        <option value="">Grade/Class</option>
                                        @foreach ($classes as $item)
                                        <option value="{{ $item->id }}" >{{ word_view($item->name) }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('grad'))
                                    <div class="text-danger">
                                        {{ $errors->first('grad') }}
                                    </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-md full-width pop-login">Register</button>
                                </div>
                                <p class="text-center">Or</p>
                                <div class="form-group">
                                    <a href="{{ route('google') }}" class="btn btn-md full-width pop-login">Register with
                                        Google</a>
                                </div>
                            </form>
                        </div>
                        <div class="text-center">
                            <p class="mt-3"><i class="ti-user mr-1"></i>Already Have An Account? <a href="register.php"
                                    class="link">Go For LogIn</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal -->

        <a id="back2Top" class="top-scroll" title="Back to top" href="#"><i class="ti-arrow-up"></i></a>


    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->

    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{ asset('js/jquery.min.js')}}"></script>
    <script src="{{ asset('js/popper.min.js')}}"></script>
    <script src="{{ asset('js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('js/select2.min.js')}}"></script>
    <script src="{{ asset('js/slick.js')}}"></script>
    <script src="{{ asset('js/jquery.counterup.min.js')}}"></script>
    <script src="{{ asset('js/counterup.min.js')}}"></script>
    <script src="{{ asset('js/alpine.min.js')}}"></script>
    <script src="{{ asset('js/alpine2.min.js')}}"></script>
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    {!! Toastr::message() !!}
    @yield('js')
    <script src="{{ asset('js/custom.js')}}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    </script>
    {{-- Custom js --}}
    @yield('custom_js')
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->

</body>


</html>
