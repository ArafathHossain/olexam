@extends('layouts.frontend')
@section('content')

<section class="error-wrap">
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-lg-6 col-md-10">
                <div class="text-center">

                    <img src="{{ asset('images/404.png') }}" class="img-fluid" alt="">
                    <p>Maecenas quis consequat libero, a feugiat eros. Nunc ut lacinia tortor morbi ultricies laoreet
                        ullamcorper phasellus semper</p>
                    <a class="btn btn-theme" href="{{ url('/') }}">Back To Home</a>

                </div>
            </div>

        </div>
    </div>
</section>
@endsection
