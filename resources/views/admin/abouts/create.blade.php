@extends('layouts.admin')
@section('css')

<link href="{{ asset('admin/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
<link href="{{ asset('admin/assets/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">


{{-- <link href="{{ asset('admin/assets/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet"> --}}
{{-- <link href="http://bhulua.thememinister.com/assets/dist/css/select.css" rel="stylesheet" type="text/css" /> --}}

@endsection
@section('page_header')
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Create About</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-spiral"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Create About</h1>
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
                <h6 class="fs-17 font-weight-600 mb-0">Create About</h6>
            </div>
            <div class="text-right">
                <div class="actions">
                    <a href="{{ route('admin.abouts.index') }}" class="action-item"><i
                            class="fas fa-angle-left mr-2"></i>Back</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.abouts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="title" class="font-weight-600"> Title</label>
                            <input type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                id="title" aria-describedby="emailHelp" name="title" value="{{ old('title') }}">
                            @if ($errors->has('title'))
                            <div class="text-danger">
                                {{ $errors->first('title') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Photo</label>
                            <input type="file"
                                class="custom-input-file custom-input-file--2 {{ $errors->has('photo') ? 'is-invalid' : '' }}"
                                name="photo" id="photo" onchange="photo_edit(event)" />
                            <label for="photo">
                                <i class="fa fa-upload"></i>
                                <span>file…</span>
                            </label>
                            @if ($errors->has('photo'))
                            <div class="text-danger">
                                {{ $errors->first('photo') }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row menu_item_clone">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="list_icon" class="font-weight-600">List icon</label>
                            <input type="text" class="form-control {{ $errors->has('list_icon') ? 'is-invalid' : '' }}"
                                id="list_icon" aria-describedby="emailHelp" name="list_icon[]">
                            @if ($errors->has('list_icon.*'))
                            <div class="text-danger">
                                {{ $errors->first('list_icon.*') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="list_title" class="font-weight-600">List title </label>
                            <input type="text" class="form-control {{ $errors->has('list_title') ? 'is-invalid' : '' }}"
                                id="list_title" aria-describedby="emailHelp" name="list_title[]">
                            @if ($errors->has('list_title.*'))
                            <div class="text-danger">
                                {{ $errors->first('list_title.*') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="list_content" class="font-weight-600">List content </label>

                            <textarea class="form-control {{ $errors->has('list_content') ? 'is-invalid' : '' }}"
                                name="list_content[]" id="list_content"></textarea>
                            @if ($errors->has('list_content.*'))
                            <div class="text-danger">
                                {{ $errors->first('list_content.*') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12 text-right">
                        <div class="delete_btn text-right">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <button type="button" id="add_item" class="btn btn-info btn-sm ">Add
                            New</button>
                    </div>
                </div>
                <button type="submit" class="btn btn-success ">Submit</button>
            </form>

        </div>
    </div>
</div>
@endsection
@section('js')
<script src="{{ asset('admin/assets/plugins/select2/dist/js/select2.min.js')}}"></script>
{{-- <script src="{{ asset('admin/assets/plugins/jquery.sumoselect/jquery.sumoselect.min.js')}}"></script> --}}
@endsection
@section('custom_js')
<script>
    $(".basic-single").select2();

    $(document).on('click', '#add_item', function () {
        $('.menu_item_clone:first').clone().insertAfter(".menu_item_clone:last").find('.delete_btn').append(
            '<button type="button" class=" delete_item btn btn-danger btn-sm">Delete</button>');
    }).on('click', '.delete_item', function () {
        $(this).closest('.menu_item_clone').remove();
    });

</script>
@endsection