@extends('layouts.admin')

@section('page_header')
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Create Subject</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-spiral"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Create Subject</h1>
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
                <h6 class="fs-17 font-weight-600 mb-0">Create Subject</h6>
            </div>
            <div class="text-right">
                <div class="actions">
                    <a href="{{ route('admin.subjects.index') }}" class="action-item"><i
                            class="fas fa-angle-left mr-2"></i>Back</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.subjects.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name" class="font-weight-600">Subject Name</label>
                            <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                id="name" aria-describedby="emailHelp" placeholder="Name" name="name">
                            @if ($errors->has('name'))
                            <div class="text-danger">
                                {{ $errors->first('name') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
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
                        <img width="40px" src="" alt="">
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="color" class="font-weight-600">Select Color</label>
                            <select id="color"
                                class="form-control basic-single {{ $errors->has('color') ? 'is-invalid' : '' }}"
                                name="color">
                                <option disabled="disabled" selected="selected" value="">Select</option>
                                @foreach (subject_color() as $color)
                                <option value="{{ $color }}"
                                    style="background: rgb({{ $color }})"></option>
                                @endforeach
                            </select>
                            @if ($errors->has('color'))
                            <div class="text-danger">
                                {{ $errors->first('color') }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>

        </div>
    </div>
</div>
@endsection
@section('js')
{{-- <script src="{{ asset('admin/assets/dist/js/pages/forms-basic.active.js') }}"></script> --}}
@endsection
@section('custom_js')
<script>
    function photo_edit(e) {
        let file = e.target.files[0];
        let reader = new FileReader();
        if (file["size"] < 2111775) {
            reader.onloadend = (file) => {
                document.getElementById('photo').src = reader.result;
            };
            reader.readAsDataURL(file);
        } else {
            alert("File size can not be bigger than 2 MB");
        }
    }
    $('.form-control').on('change, keyup', function(){
        if ($(this).val() != '') {
            $(this).removeClass('is-invalid');
            $(this).parent().find('.text-danger').addClass('d-none');
        }
    });
    $('#color').on('change', function () {
        var color = $(this).val();
        $(this).css("background", "rgb(" + color + ")");
        if ($(this).val()) {
            $(this).removeClass('is-invalid');
        }
    });

</script>
@endsection
