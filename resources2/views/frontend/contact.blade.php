@extends('layouts.frontend')
@section('content')
<!-- ============================ Page Title Start================================== -->
<section class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                {{-- Breadcrumbs --}}
                @include('partials.breadcrumbs')
            </div>
        </div>
    </div>
</section>
<!-- ============================ Page Title End ================================== -->

<!-- ============================ Agency List Start ================================== -->
<section class="bg-light">

    <div class="container">

        <!-- row Start -->
        <div class="row">

            <div class="col-lg-8 col-md-7">
                <div class="prc_wrap">

                    <div class="prc_wrap_header">
                        <h4 class="property_block_title">Have Any Query?</h4>
                    </div>
                    <form action="{{ route('contact.send') }}" method="POST">
                        @csrf
                        <div class="prc_wrap-body">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control simple" name="name"
                                            value="{{ old('name') }}">
                                        @if ($errors->has('name'))
                                        <div class="text-danger">
                                            {{ $errors->first('name') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control simple" name="email"
                                            value="{{ old('email') }}">
                                        @if ($errors->has('email'))
                                        <div class="text-danger">
                                            {{ $errors->first('email') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Subject</label>
                                <input type="text" class="form-control simple" name="subject"
                                    value="{{ old('subject') }}">
                                @if ($errors->has('subject'))
                                <div class="text-danger">
                                    {{ $errors->first('subject') }}
                                </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Message</label>
                                <textarea class="form-control simple" name="message">{{ old('message') }}</textarea>
                                @if ($errors->has('message'))
                                <div class="text-danger">
                                    {{ $errors->first('message') }}
                                </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <button class="btn btn-theme" type="submit">Send</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

            <div class="col-lg-4 col-md-5">

                <div class="prc_wrap">

                    <div class="prc_wrap_header">
                        <h4 class="property_block_title">Reach Us</h4>
                    </div>

                    <div class="prc_wrap-body">
                        <div class="contact-info">

                            <h2>Get In Touch</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do </p>

                            <div class="cn-info-detail">
                                <div class="cn-info-icon">
                                    <i class="ti-home"></i>
                                </div>
                                <div class="cn-info-content">
                                    <h4 class="cn-info-title">Reach Us</h4>
                                    {!! site_setting('address') !!}
                                </div>
                            </div>

                            <div class="cn-info-detail">
                                <div class="cn-info-icon">
                                    <i class="ti-email"></i>
                                </div>
                                <div class="cn-info-content">
                                    <h4 class="cn-info-title">Drop A Mail</h4>
                                   {!! site_setting('email') !!}
                                </div>
                            </div>

                            <div class="cn-info-detail">
                                <div class="cn-info-icon">
                                    <i class="ti-mobile"></i>
                                </div>
                                <div class="cn-info-content">
                                    <h4 class="cn-info-title">Call Us</h4>
                                    {!! site_setting('phone') !!}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-- /row -->

    </div>

</section>
<!-- ============================ Agency List End ================================== -->
@endsection
