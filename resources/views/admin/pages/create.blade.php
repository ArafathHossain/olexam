@extends('layouts.admin')
@section('css')
@endsection
@section('page_header')
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Create Page</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-spiral"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Create Page</h1>
                <small>From now on you will start your activities.</small>
            </div>
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="card mb-4">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h6 class="fs-17 font-weight-600 mb-0">Create Page</h6>
            </div>
            <div class="text-right">
                <div class="actions">
                    <a href="{{ route('admin.pages.index') }}" class="action-item"><i
                            class="fas fa-angle-left mr-2"></i>Back</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.pages.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group ">
                    <label for="title" class="font-weight-600">Page Title</label>

                    <input type="text" id="title" name="title"
                        class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}">
                    @if ($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                    @endif

                </div>
                <div class="form-group ">
                    <label for="content" class="font-weight-600">Content</label>
                    <textarea name="content" id="content" rows="4" placeholder="Description..."
                        class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}"></textarea>
                    @if ($errors->has('content'))
                    <span class="text-danger">{{ $errors->first('content') }}</span>
                    @endif

                </div>

                <div class="form-group">
                    <div class="checkbox checkbox-success pl-0">
                        <input id="status" type="checkbox" name="status" value="on">
                        <label for="status">Publish</label>
                    </div>
                </div>

                <div class="form-actions form-group">
                    <button type="submit" class="btn btn-primary btn-md">Save</button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
@section('js')
<script src="//cdn.ckeditor.com/4.15.0/full/ckeditor.js"></script>
@endsection
@section('custom_js')
<script>
    CKEDITOR.replace('content');

</script>
@endsection
