@extends('layouts.admin')

@section('page_header')
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Create Faq</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-spiral"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Create Faq</h1>
                <small>From now on you will start your activities.</small>
            </div>
        </div>
    </div>
</div>
@endsection
@section('content')
{{-- <div class="col-md-6 mx-auto">


</div> --}}
<div class="card mb-4">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h6 class="fs-17 font-weight-600 mb-0">Create Faq</h6>
            </div>
            <div class="text-right">
                <div class="actions">
                    <a href="{{ route('admin.faqs.index') }}" class="action-item"><i
                            class="fas fa-angle-left mr-2"></i>Back</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.faqs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tab" class="font-weight-600">Tab Name (Spelling check)</label>
                            <input type="text" class="form-control {{ $errors->has('tab') ? 'is-invalid' : '' }}"
                                id="tab" aria-describedby="emailHelp" placeholder="Tab" name="tab"
                                value="{{ old('tab') }}">
                            @if ($errors->has('tab'))
                            <div class="text-danger">
                                {{ $errors->first('tab') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="title" class="font-weight-600">Title</label>
                            <input type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                id="title" aria-describedby="emailHelp" placeholder="title" name="title"
                                value="{{ old('title') }}">
                            @if ($errors->has('title'))
                            <div class="text-danger">
                                {{ $errors->first('title') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group ">
                            <label for="content" class="font-weight-600">Content</label>
                            <textarea name="content" id="content" rows="4" placeholder="Description..."
                                class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}">{!! old('content') !!}</textarea>
                            @if ($errors->has('content'))
                            <span class="text-danger">{{ $errors->first('content') }}</span>
                            @endif

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="checkbox checkbox-success pl-0">
                                <input id="status" type="checkbox" name="status" value="on" checked>
                                <label for="status">Active</label>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>

        </div>
    </div>
</div>
@endsection
{{-- @section('js')
<script src="//cdn.ckeditor.com/4.15.0/basic/ckeditor.js"></script>
@endsection
@section('custom_js')
<script>
    CKEDITOR.replace('content');

</script>
@endsection --}}