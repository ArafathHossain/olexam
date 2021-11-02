@extends('layouts.admin')
@section('page_header')
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Manage Home</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-spiral"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Manage Home</h1>
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
                <h6 class="fs-17 font-weight-600 mb-0">Manage Home</h6>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.update.home_page') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="title" class="font-weight-600">Home Page Title</label>
                            <input type="text" id="title" name="title"
                                class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                value="{{ home_page('title', 'Online Live MCQ Exams At Your Fingertips') }}">
                            @if ($errors->has('title'))
                            <div class="text-danger">
                                {{ $errors->first('title') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="content" class="font-weight-600">Home Page Content</label>
                            <textarea class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}"
                                name="content"
                                id="content">{{ home_page('content','Attend Live Exams Online. Explore thousands of Live MCQ Exam Packages!!') }}</textarea>
                            @if ($errors->has('content'))
                            <div class="text-danger">
                                {{ $errors->first('content') }}
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row align-items-center">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="font-weight-600">Banner Photo</label>
                                    <input type="file"
                                        class="custom-input-file custom-input-file--2 {{ $errors->has('banner_photo') ? 'is-invalid' : '' }}"
                                        name="banner_photo" id="banner_photo" />
                                    <label for="banner_photo">
                                        <i class="fa fa-upload"></i>
                                        <span>file…</span>
                                    </label>
                                    @if ($errors->has('banner_photo'))
                                    <div class="text-danger">
                                        {{ $errors->first('banner_photo') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <img src="/{{ home_page('banner_photo', 'images/banner-2.jpg') }}" alt="" class="img-fluid">
                            </div>
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