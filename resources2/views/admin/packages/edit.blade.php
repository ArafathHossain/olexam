@extends('layouts.admin')
@section('css')

<link href="{{ asset('admin/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
<link href="{{ asset('admin/assets/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">


<link href="{{ asset('admin/assets/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet">
{{-- <link href="http://bhulua.thememinister.com/assets/dist/css/select.css" rel="stylesheet" type="text/css" /> --}}

@endsection
@section('page_header')
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Update Package</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-spiral"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Update Package</h1>
                <small>Update Your Package Here.</small>
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
                <h6 class="fs-17 font-weight-600 mb-0">Update Package</h6>
            </div>
            <div class="text-right">
                <div class="actions">
                    <a href="{{ route('admin.packages.index') }}" class="action-item"><i
                            class="fas fa-angle-left mr-2"></i>Back</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.packages.update', $package->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="title" class="font-weight-600">Package Title</label>
                            <input type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                id="title" aria-describedby="emailHelp" placeholder="Name" name="title"
                                value="{{ $package->title }}">
                            @if ($errors->has('title'))
                            <div class="text-danger">
                                {{ $errors->first('title') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="class_id" class="font-weight-600">Select Class</label>
                            <select id="class_id"
                                class="form-control basic-single {{ $errors->has('class_id') ? 'is-invalid' : '' }}"
                                name="class_id">
                                <option disabled="disabled" selected="selected" value="">Select</option>
                                @foreach($classes as $key => $class)
                                <option value="{{ $class->id }}"
                                    {{ $package->class_id == $class->id  ? 'selected' : '' }}>
                                    {{ word_view($class->name) }}
                                </option>
                                @endforeach
                            </select>
                            @if ($errors->has('class_id'))
                            <div class="text-danger">
                                {{ $errors->first('class_id') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="subject_id" class="font-weight-600">Select Subject</label>
                            @php

                            $subjects = App\Models\StudentClass::find($package->class_id)->subjects;
                            @endphp
                            <select id="subject_id"
                                class="form-control basic-single {{ $errors->has('subject_ids') ? 'is-invalid' : '' }}"
                    name="subject_id">
                    @foreach($subjects as $key => $subject)
                    <option value="{{ $subject->id }}" {{ $package->subject_id == $subject->id  ? 'selected' : '' }}>
                        {{ word_view($subject->name) }}
                    </option>
                    @endforeach

                    </select>
                    @if ($errors->has('subject_id'))
                    <div class="text-danger">
                        {{ $errors->first('subject_id') }}
                    </div>
                    @endif
                </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="description" class="font-weight-600">Description</label>
                <textarea class="form-control" name="description" id="description" rows="5">
                            {!! $package->description !!}
                            </textarea>
                @if ($errors->has('description'))
                <div class="text-danger">
                    {{ $errors->first('description') }}
                </div>
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="package_type" class="font-weight-600">Package Type</label>
                <select id="package_type"
                    class="form-control basic-single {{ $errors->has('package_type') ? 'is-invalid' : '' }}"
                    name="package_type">
                    <option disabled="disabled" selected="selected" value="">Select</option>
                    <option value="0" {{ $package->package_type == 0  ? 'selected' : '' }}>
                        Free Package
                    </option>
                    <option value="1" {{ $package->package_type == 1 ? 'selected' : '' }}>
                        Premium Package
                    </option>
                </select>
                @if ($errors->has('package_type'))
                <div class="text-danger">
                    {{ $errors->first('package_type') }}
                </div>
                @endif
            </div>
        </div>

        <div class="col-md-4 ">
            <div class="form-group">
                <label for="mcq_sets" class="font-weight-600">Select Question Sets for this Package</label>
                <select multiple="multiple" id="mcq_sets"
                    class="form-control select2 {{ $errors->has('mcq_sets') ? 'is-invalid' : '' }}" name="mcq_sets[]">
                    @foreach($mcqs as $key => $mcq)
                    <option value="{{ $mcq->id }}"
                        {{ in_array($mcq->id, $package->mcqs->pluck('id')->toArray())  ? 'selected' : '' }}>
                        SL:{{ $mcq->sl }} - Title:{{ word_view($mcq->title) }}
                    </option>
                    @endforeach
                </select>
                @if ($errors->has('mcq_sets'))
                <div class="text-danger">
                    {{ $errors->first('mcq_sets') }}
                </div>
                @endif
            </div>
        </div>
        <div class="col-md-4 d-none org_price">
            <div class="form-group">
                <label for="org_price" class="font-weight-600">Original Price</label>
                <input type="number" class="form-control {{ $errors->has('org_price') ? 'is-invalid' : '' }}"
                    id="org_price" name="org_price" value="{{ $package->org_price }}">
                @if ($errors->has('org_price'))
                <div class="text-danger">
                    {{ $errors->first('org_price') }}
                </div>
                @endif
            </div>
        </div>
        <div class="col-md-4 d-none sale_price">
            <div class="form-group">
                <label for="sale_price" class="font-weight-600">Sale Price</label>
                <input type="number" class="form-control {{ $errors->has('sale_price') ? 'is-invalid' : '' }}"
                    id="sale_price" name="sale_price" value="{{$package->sale_price }}">
                @if ($errors->has('sale_price'))
                <div class="text-danger">
                    {{ $errors->first('sale_price') }}
                </div>
                @endif
            </div>
        </div>
        <div class="col-md-4 d-none free_mcq_for_premium">
            @php
            $free_mcq = explode(',', $package->free_mcq)
            @endphp
            <label for="free_mcq" class="font-weight-600">Select Only Free Question Sets</label>
            <select multiple="multiple" id="free_mcq"
                class="form-control  {{ $errors->has('free_mcq') ? 'is-invalid' : '' }}" name="free_mcq[]">

                @foreach($mcqs as $key => $mcq)
                <option value="{{ $mcq->id }}" {{ in_array($mcq->id, $free_mcq)  ? 'selected' : '' }}>
                    SL:{{ $mcq->sl }} - Title:{{ word_view($mcq->title) }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 ">
            <div class="form-group">
                <label for="">Thumbnail Image</label>
                <input type="file"
                    class="custom-input-file custom-input-file--2 {{ $errors->has('photo') ? 'is-invalid' : '' }}"
                    name="photo" id="photo" />
                <label for="photo">
                    <i class="fa fa-upload"></i>
                    <span>Upload Image</span>
                </label>
                @if ($errors->has('photo'))
                <div class="text-danger">
                    {{ $errors->first('photo') }}
                </div>
                @endif
            </div>
            @if ($package->photo)
            <img width="150px" src="{{ asset($package->photo) }}" alt="">
            @endif
        </div>
        <div class="col-md-4 ">
            <div class="form-group">
                <label for="video" class="font-weight-600">Video</label>
                <input type="text" class="form-control {{ $errors->has('video') ? 'is-invalid' : '' }}" id="video"
                    name="video" value="{{ $package->video }}"
                    placeholder="https://www.youtube.com/watch?v=SMKPKGW083c">
                @if ($errors->has('video'))
                <div class="text-danger">
                    {{ $errors->first('video') }}
                </div>
                @endif
            </div>
        </div>
        <div class="col-md-4 ">
            <div class="form-group">
                <label for="skill_level" class="font-weight-600">Skill Level</label>
                <input type="text" class="form-control {{ $errors->has('skill_level') ? 'is-invalid' : '' }}"
                    id="skill_level" name="skill_level" value="{{ $package->skill_level }}">
                @if ($errors->has('skill_level'))
                <div class="text-danger">
                    {{ $errors->first('skill_level') }}
                </div>
                @endif
            </div>
        </div>
        <div class="col-md-4 ">
            <div class="form-group">
                <label for="mediam" class="font-weight-600">Medium</label>
                <input type="text" class="form-control {{ $errors->has('mediam') ? 'is-invalid' : '' }}" id="mediam"
                    name="mediam" value="{{ $package->mediam }}">
                @if ($errors->has('mediam'))
                <div class="text-danger">
                    {{ $errors->first('mediam') }}
                </div>
                @endif
            </div>
        </div>
        <div class="col-md-4 ">
            @php
            $features = $package->features;
            $features = explode('||', $features)

            @endphp
            @foreach ($features as $feature)
            <div class="form-group features_clone">
                <label for="features" class="font-weight-600">Package Features</label>
                <input type="text" class="form-control {{ $errors->has('features') ? 'is-invalid' : '' }}" id="features"
                    name="features[]" value="{{ $feature }}">
                @if ($errors->has('features'))
                <div class="text-danger">
                    {{ $errors->first('features') }}
                </div>
                @endif
                <div class="delete_btn text-right">

                </div>
            </div>
            @endforeach
            <button type="button" id="add_item" class="btn btn-info btn-sm mt-2">Add New Feature</button>
        </div>
        <div class="col-md-4 ">
            <div class="form-group">
                <label for="features" style="visibility: hidden" class="font-weight-600">Features</label>
                <div class="checkbox checkbox-success pl-0">
                    <input id="popular_package" type="checkbox" name="popular_package" value="on"
                        {{ $package->popular_package == 1 ? 'checked' : '' }}>
                    <label for="popular_package">Popular Package</label>
                </div>
            </div>
        </div>
        <div class="col-md-4 ">
            <div class="form-group">
                <label for="features" style="visibility: hidden" class="font-weight-600">Features</label>
                <div class="checkbox checkbox-success pl-0">
                    <input id="featured_package" type="checkbox" name="featured_package" value="on"
                        {{ $package->featured_package == 1 ? 'checked' : '' }}>
                    <label for="featured_package">Featured Package</label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 mx-auto text-center">

        <button type="submit" class="btn btn-success">Update</button>
    </div>
    </form>

</div>
</div>
</div>
@endsection
@section('js')
{{-- <script src="{{ asset('admin/assets/plugins/ckeditor/ckeditor.js')}}"></script> --}}
<script src="//cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>
{{-- <script src="{{ asset('admin/assets/plugins/ckeditor/ckeditor.active.js')}}"></script> --}}
<script src="{{ asset('admin/assets/plugins/select2/dist/js/select2.min.js')}}"></script>
<script src="{{ asset('admin/assets/plugins/jquery.sumoselect/jquery.sumoselect.min.js')}}"></script>
<script src="{{ asset('admin/assets/dist/js/pages/forms-basic.active.js') }}"></script>
@endsection
@section('custom_js')
<script>
    $('.select2').SumoSelect({
        selectAll: true,
        search: true
    });
    $('#free_mcq').SumoSelect({
        selectAll: true,
        search: true
    });
    $(".basic-single").select2();
    if ($("#package_type").val() == 1) {
        $('.free_mcq_for_premium, .org_price, .sale_price').removeClass('d-none').addClass('d-block');
    } else {
        $('.free_mcq_for_premium, .org_price, .sale_price').removeClass('d-block').addClass('d-none');
    }
    $("#package_type").on('change', function () {
        if ($(this).val() == 1) {
            $('.free_mcq_for_premium, .org_price, .sale_price').removeClass('d-none').addClass('d-block');
        } else {
            $('.free_mcq_for_premium, .org_price, .sale_price').removeClass('d-block').addClass('d-none');
        }
    });

    $("#class_id").on('change', function () {
        var class_id = $(this).val();
        if (!class_id) {
            return
        }
        $.ajax({
            type: 'POST',
            url: "{{ route('admin.ajax_subject') }}",
            data: {
                class_id: class_id
            },
            success: function (data) {
                $('#subject_id').html(data);
            }
        });
    });

    $('.features_clone').not(":first").find('.delete_btn').append(
        '<button type="button" class=" delete_item btn btn-danger btn-sm mt-2">Delete</button>');
    $(document).on('click', '#add_item', function () {
        $('.features_clone:first').clone().insertAfter(".features_clone:last").find('.delete_btn').append(
            '<button type="button" class=" delete_item btn btn-danger btn-sm mt-2">Delete</button>');
    }).on('click', '.delete_item', function () {
        $(this).closest('.features_clone').remove();
    });
    CKEDITOR.replace('description');

</script>
@endsection
