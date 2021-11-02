@extends('layouts.frontend')

@section('content')
<div class="container">

    <div class="col-md-6 mx-auto">
        <div class="card">
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
                                placeholder="*******" name="password">
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
                                google</a>
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
                    <p class="mt-2">Haven't Any Account? <a href="{{ route('register') }}" class="link">Click here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
