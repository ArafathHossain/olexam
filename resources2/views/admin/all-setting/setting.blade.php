@extends('layouts.admin')
@section('page_header')
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Manage Setting</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-spiral"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Manage Setting</h1>
                <small>From now on you will start your activities.</small>
            </div>
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="card mb-4">
    @if(session()->get('success'))
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ session()->get('success') }} </strong>
    </div>
    @endif
    @if(session()->get('error'))
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ session()->get('error') }} </strong>
    </div>
    @endif
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h6 class="fs-17 font-weight-600 mb-0">Manage Setting</h6>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.update.setting') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row align-items-center">
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="title" class="font-weight-600">Website Title</label>
                            <input type="text" id="title" name="title"
                                class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                value="{{ site_setting('title', 'Online Live MCQ Exam Online') }}">
                            @if ($errors->has('title'))
                            <div class="text-danger">
                                {{ $errors->first('title') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="app_name" class="font-weight-600">Application Name</label>
                            <input type="text" id="app_name" name="app_name"
                                class="form-control {{ $errors->has('app_name') ? 'is-invalid' : '' }}"
                                value="{{ site_setting('app_name', 'OLM') }}">
                            @if ($errors->has('app_name'))
                            <div class="text-danger">
                                {{ $errors->first('app_name') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="row align-items-center">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="font-weight-600">Website Logo</label>
                                    <input type="file"
                                        class="custom-input-file custom-input-file--2 {{ $errors->has('logo') ? 'is-invalid' : '' }}"
                                        name="logo" id="logo" />
                                    <label for="logo">
                                        <i class="fa fa-upload"></i>
                                        <span>file…</span>
                                    </label>
                                    @if ($errors->has('logo'))
                                    <div class="text-danger">
                                        {{ $errors->first('logo') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <img src="/{{ site_setting('logo') }}" alt="" class="img-fluid">
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="row align-items-center">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="font-weight-600">Website Favicon</label>
                                    <input type="file"
                                        class="custom-input-file custom-input-file--2 {{ $errors->has('favicon') ? 'is-invalid' : '' }}"
                                        name="favicon" id="favicon" />
                                    <label for="favicon">
                                        <i class="fa fa-upload"></i>
                                        <span>file…</span>
                                    </label>
                                    @if ($errors->has('favicon'))
                                    <div class="text-danger">
                                        {{ $errors->first('favicon') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <img src="/{{ site_setting('favicon') }}" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="row align-items-center">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="font-weight-600">Footer Logo</label>
                                    <input type="file"
                                        class="custom-input-file custom-input-file--2 {{ $errors->has('footer_logo') ? 'is-invalid' : '' }}"
                                        name="footer_logo" id="footer_logo" />
                                    <label for="footer_logo">
                                        <i class="fa fa-upload"></i>
                                        <span>file…</span>
                                    </label>
                                    @if ($errors->has('footer_logo'))
                                    <div class="text-danger">
                                        {{ $errors->first('footer_logo') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <img src="/{{ site_setting('footer_logo') }}" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12"></div>
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="address" class="font-weight-600">Website Address</label>
                            <input type="text" id="address" name="address"
                                class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}"
                                value="{{ site_setting('address', 'Dhaka, Bangladesh') }}">
                            @if ($errors->has('address'))
                            <div class="text-danger">
                                {{ $errors->first('address') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="phone" class="font-weight-600">Website Phone</label>
                            <input type="text" id="phone" name="phone"
                                class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                                value="{{ site_setting('phone', '+1 234-567-8910') }}">
                            @if ($errors->has('phone'))
                            <div class="text-danger">
                                {{ $errors->first('phone') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="email" class="font-weight-600">Website Email</label>
                            <input type="email" id="email" name="email"
                                class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                value="{{ site_setting('email', 'info@onlinelivemcq.com') }}">
                            @if ($errors->has('email'))
                            <div class="text-danger">
                                {{ $errors->first('email') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="copyright" class="font-weight-600">Website Copyright</label>
                            <input type="copyright" id="copyright" name="copyright"
                                class="form-control {{ $errors->has('copyright') ? 'is-invalid' : '' }}"
                                value="{{ site_setting('copyright', '© 2020 OLM - Online Live MCQ. ') }}">
                            @if ($errors->has('copyright'))
                            <div class="text-danger">
                                {{ $errors->first('copyright') }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <h4>Email Setup</h4>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="from_email" class="font-weight-600">From Email</label>
                            <input type="text" id="from_email" name="from_email"
                                class="form-control {{ $errors->has('from_email') ? 'is-invalid' : '' }}"
                                value="{{ site_setting('from_email') }}">
                            @if ($errors->has('from_email'))
                            <div class="text-danger">
                                {{ $errors->first('from_email') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="mail_mailer" class="font-weight-600">Email Mailer</label>
                            <input type="text" id="mail_mailer" name="mail_mailer"
                                class="form-control {{ $errors->has('mail_mailer') ? 'is-invalid' : '' }}"
                                value="{{ site_setting('mail_mailer') }}">
                            @if ($errors->has('mail_mailer'))
                            <div class="text-danger">
                                {{ $errors->first('mail_mailer') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="mail_host" class="font-weight-600">Email Host</label>
                            <input type="text" id="mail_host" name="mail_host"
                                class="form-control {{ $errors->has('mail_host') ? 'is-invalid' : '' }}"
                                value="{{ site_setting('mail_host') }}">
                            @if ($errors->has('mail_host'))
                            <div class="text-danger">
                                {{ $errors->first('mail_host') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="mail_port" class="font-weight-600">Email Port</label>
                            <input type="text" id="mail_port" name="mail_port"
                                class="form-control {{ $errors->has('mail_port') ? 'is-invalid' : '' }}"
                                value="{{ site_setting('mail_port') }}">
                            @if ($errors->has('mail_port'))
                            <div class="text-danger">
                                {{ $errors->first('mail_port') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="mail_username" class="font-weight-600">Email Username</label>
                            <input type="text" id="mail_username" name="mail_username"
                                class="form-control {{ $errors->has('mail_username') ? 'is-invalid' : '' }}"
                                value="{{ site_setting('mail_username') }}">
                            @if ($errors->has('mail_username'))
                            <div class="text-danger">
                                {{ $errors->first('mail_username') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="mail_password" class="font-weight-600">Email Password</label>
                            <input type="text" id="mail_password" name="mail_password"
                                class="form-control {{ $errors->has('mail_password') ? 'is-invalid' : '' }}"
                                value="{{ site_setting('mail_password') }}">
                            @if ($errors->has('mail_password'))
                            <div class="text-danger">
                                {{ $errors->first('mail_password') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="mail_encryption" class="font-weight-600">Email TLS</label>
                            <input type="text" id="mail_encryption" name="mail_encryption"
                                class="form-control {{ $errors->has('mail_encryption') ? 'is-invalid' : '' }}"
                                value="{{ site_setting('mail_encryption') }}">
                            @if ($errors->has('mail_encryption'))
                            <div class="text-danger">
                                {{ $errors->first('mail_encryption') }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <h4>Payment Setup</h4>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="payment_mode" class="font-weight-600">Payment Mode</label>
                            <select id="payment_mode"
                                class="form-control basic-single {{ $errors->has('payment_mode') ? 'is-invalid' : '' }}"
                                name="payment_mode">
                                <option disabled="disabled" selected="selected" value="">Select</option>
                                <option value="sandbox" {{ site_setting('payment_mode') == 'sandbox'  ? 'selected' : '' }}>
                                    Sandbox
                                </option>
                                <option value="live" {{ site_setting('payment_mode') == 'live' ? 'selected' : '' }}>
                                    Live
                                </option>
                            </select>
                            @if ($errors->has('payment_mode'))
                            <div class="text-danger">
                                {{ $errors->first('payment_mode') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="store_id" class="font-weight-600">SSL Store Id</label>
                            <input type="text" id="store_id" name="store_id"
                                class="form-control {{ $errors->has('store_id') ? 'is-invalid' : '' }}"
                                value="{{ site_setting('store_id') }}">
                            @if ($errors->has('store_id'))
                            <div class="text-danger">
                                {{ $errors->first('store_id') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="store_password" class="font-weight-600">SSL Store Password</label>
                            <input type="text" id="store_password" name="store_password"
                                class="form-control {{ $errors->has('store_password') ? 'is-invalid' : '' }}"
                                value="{{ site_setting('store_password') }}">
                            @if ($errors->has('store_password'))
                            <div class="text-danger">
                                {{ $errors->first('store_password') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="ssl_api_url" class="font-weight-600">SSL Api Url</label>
                            <input type="text" id="ssl_api_url" name="ssl_api_url"
                                class="form-control {{ $errors->has('ssl_api_url') ? 'is-invalid' : '' }}"
                                value="{{ site_setting('ssl_api_url', 'https://sandbox.sslcommerz.com') }}">
                            @if ($errors->has('ssl_api_url'))
                            <div class="text-danger">
                                {{ $errors->first('ssl_api_url') }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <h4>Google Login Setup</h4>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="google_id" class="font-weight-600">Google Client Id</label>
                            <input type="text" id="google_id" name="google_id"
                                class="form-control {{ $errors->has('google_id') ? 'is-invalid' : '' }}"
                                value="{{ site_setting('google_id') }}">
                            @if ($errors->has('google_id'))
                            <div class="text-danger">
                                {{ $errors->first('google_id') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="google_key" class="font-weight-600">Google Secret Key</label>
                            <input type="text" id="google_key" name="google_key"
                                class="form-control {{ $errors->has('google_key') ? 'is-invalid' : '' }}"
                                value="{{ site_setting('google_key') }}">
                            @if ($errors->has('google_key'))
                            <div class="text-danger">
                                {{ $errors->first('google_key') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="google_redirect" class="font-weight-600">Google Redirect (do't touch!)</label>
                            <input type="text" id="google_redirect" name="google_redirect"
                                class="form-control {{ $errors->has('google_redirect') ? 'is-invalid' : '' }}"
                                value="{{ site_setting('google_redirect', url('/').'/auth/google/callback') }}" readonly>
                            @if ($errors->has('google_redirect'))
                            <div class="text-danger">
                                {{ $errors->first('google_redirect') }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <h4>MAILCHIMP SETUP </h4>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mailchimp_api" class="font-weight-600">Mailchimp Api Key</label>
                            <input type="text" id="mailchimp_api" name="mailchimp_api"
                                class="form-control {{ $errors->has('mailchimp_api') ? 'is-invalid' : '' }}"
                                value="{{ site_setting('mailchimp_api') }}">
                            @if ($errors->has('mailchimp_api'))
                            <div class="text-danger">
                                {{ $errors->first('mailchimp_api') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mailchimp_list" class="font-weight-600">Mailchimp List Id</label>
                            <input type="text" id="mailchimp_list" name="mailchimp_list"
                                class="form-control {{ $errors->has('mailchimp_list') ? 'is-invalid' : '' }}"
                                value="{{ site_setting('mailchimp_list') }}">
                            @if ($errors->has('mailchimp_list'))
                            <div class="text-danger">
                                {{ $errors->first('mailchimp_list') }}
                            </div>
                            @endif
                        </div>
                    </div>
                   
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <h4>Social Link</h4>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="fb_link" class="font-weight-600">Fackbook Link (with https://)</label>
                            <input type="text" id="fb_link" name="fb_link"
                                class="form-control {{ $errors->has('fb_link') ? 'is-invalid' : '' }}"
                                value="{{ site_setting('fb_link', '#') }}">
                            @if ($errors->has('fb_link'))
                            <div class="text-danger">
                                {{ $errors->first('fb_link') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="tw_link" class="font-weight-600">Twitter Link (with https://)</label>
                            <input type="text" id="tw_link" name="tw_link"
                                class="form-control {{ $errors->has('tw_link') ? 'is-invalid' : '' }}"
                                value="{{ site_setting('tw_link','#') }}">
                            @if ($errors->has('tw_link'))
                            <div class="text-danger">
                                {{ $errors->first('tw_link') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="in_link" class="font-weight-600">Instagram Link (with https://)</label>
                            <input type="text" id="in_link" name="in_link"
                                class="form-control {{ $errors->has('in_link') ? 'is-invalid' : '' }}"
                                value="{{ site_setting('in_link','#') }}">
                            @if ($errors->has('in_link'))
                            <div class="text-danger">
                                {{ $errors->first('in_link') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="ld_link" class="font-weight-600">Linkedin Link (with https://)</label>
                            <input type="text" id="ld_link" name="ld_link"
                                class="form-control {{ $errors->has('ld_link') ? 'is-invalid' : '' }}"
                                value="{{ site_setting('ld_link','#') }}">
                            @if ($errors->has('ld_link'))
                            <div class="text-danger">
                                {{ $errors->first('ld_link') }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-actions form-group">
                    <button type="submit" class="btn btn-primary btn-lg">Save</button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
@section('js')
<script src="{{ asset('admin/assets/dist/js/pages/forms-basic.active.js') }}"></script>
@endsection