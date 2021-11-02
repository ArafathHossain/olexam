@extends('layouts.frontend')

@section('content')
<div class="container">
    <div class="col-md-6 mx-auto">
        <div class="modal-body">
            <h4 class="modal-header-title">Sign Up</h4>
            <div class="login-form">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            placeholder="Full Name">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="email" class="form-control  @error('email') is-invalid @enderror " name="email"
                            placeholder="Email">
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
                            name="password" placeholder="Password">
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
                        <button type="submit" class="btn btn-md full-width pop-login">Sign Up</button>
                    </div>
                    <p class="text-center">Or</p>
                    <div class="form-group">
                        <a href="{{ route('google') }}" class="btn btn-md full-width pop-login">Sign up with
                            google</a>
                    </div>
                </form>
            </div>
            <div class="text-center">
                <p class="mt-3"><i class="ti-user mr-1"></i>Already Have An Account? <a href="{{ route('login') }}"
                        class="link">Go For LogIn</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
