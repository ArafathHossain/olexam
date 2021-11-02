@extends('layouts.admin')
@section('css')

    <link href="{{ asset('admin/assets/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet">

@endsection
@section('page_header')
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Create Live Exam</li>
            </ol>
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-spiral"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Create Live Exam</h1>
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
                    <h6 class="fs-17 font-weight-600 mb-0">Create Live Exam</h6>
                </div>
                <div class="text-right">
                    <div class="actions">
                        <a href="{{ route('admin.live-exams.index') }}" class="action-item"><i
                                class="fas fa-angle-left mr-2"></i>Back</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.live-exams.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="title" class="font-weight-600">Exam Title</label>
                            <input type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                id="title" name="title" value="{{ old('title') }}">
                            @if ($errors->has('title'))
                                <div class="text-danger">
                                    {{ $errors->first('title') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="start_time" class="font-weight-600">Start Time</label>
                            <input type="text" class="form-control {{ $errors->has('start_time') ? 'is-invalid' : '' }}"
                                id="start_time" name="start_time" value="{{ old('start_time') }}">
                            @if ($errors->has('start_time'))
                                <div class="text-danger">
                                    {{ $errors->first('start_time') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="end_time" class="font-weight-600">End Time</label>
                            <input type="text" class="form-control {{ $errors->has('end_time') ? 'is-invalid' : '' }}"
                                id="end_time" name="end_time" value="{{ old('end_time') }}">
                            @if ($errors->has('end_time'))
                                <div class="text-danger">
                                    {{ $errors->first('end_time') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4 ">
                        <div class="form-group">
                            <label for="main_mcq_id" class="font-weight-600">MCQ Set</label>
                            <select
                                class="form-control basic-single {{ $errors->has('main_mcq_id') ? 'is-invalid' : '' }}"
                                name="main_mcq_id">
                                <option value="" disabled="disabled" selected="selected">Select</option>
                                @foreach ($mcqs as $key => $mcq)
                                    <option value="{{ $mcq->id }}" {{ old('main_mcq_id') ? 'selected' : '' }}>
                                        SL: {{ $mcq->sl }} - Title: {{ word_view($mcq->title) }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('main_mcq_id'))
                                <div class="text-danger">
                                    {{ $errors->first('main_mcq_id') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 ">
                        <div class="form-group">
                            <label for="student_class_id" class="font-weight-600">Select Class</label>
                            <select
                                class="form-control basic-single {{ $errors->has('student_class_id') ? 'is-invalid' : '' }}"
                                name="student_class_id">
                                <option value="" disabled="disabled" selected="selected">Select</option>
                                @foreach ($classes as $key => $class)
                                    <option value="{{ $class->id }}" {{ old('student_class_id') ? 'selected' : '' }}>
                                        {{ word_view($class->name) }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('student_class_id'))
                                <div class="text-danger">
                                    {{ $errors->first('student_class_id') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 ">
                        <div class="form-group">
                            <label for="exam_type" class="font-weight-600">Select Type</label>
                            <select class="form-control basic-single {{ $errors->has('exam_type') ? 'is-invalid' : '' }}"
                                name="exam_type" id="exam_type">
                                <option value="" disabled="disabled" selected="selected">Select</option>
                                <option value="0" {{ old('exam_type') == 0 ? 'selected' : '' }}>Free</option>
                                <option value="1" {{ old('exam_type') == 1 ? 'selected' : '' }}>Pro</option>
                            </select>
                            @if ($errors->has('exam_type'))
                                <div class="text-danger">
                                    {{ $errors->first('exam_type') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description" class="font-weight-600">Description</label>
                            <textarea class="form-control" name="description" id="description"
                                      rows="5">{!! old('description') !!}</textarea>
                            @if ($errors->has('description'))
                                <div class="text-danger">
                                    {{ $errors->first('description') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 d-none exam_price_content">
                        <div class="form-group">
                            <label for="price" class="font-weight-600">Price</label>
                            <input type="text" class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}"
                                id="price" name="price" value="{{ old('price') }}">
                            @if ($errors->has('price'))
                                <div class="text-danger">
                                    {{ $errors->first('price') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="checkbox checkbox-success pl-0">
                        <input id="status" type="checkbox" name="status" value="on" checked>
                        <label for="status">Publish</label>
                    </div>
                </div>
                <div class="col-md-12 mx-auto text-center">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>

@endsection
@section('js')
    <script src="{{ asset('admin/assets/plugins/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/assets/dist/js/pages/forms-basic.active.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/moment/moment.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="//cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>
@endsection
@section('custom_js')
    <script>
        $(".basic-single").select2();
        $('#start_time, #end_time').daterangepicker({
            singleDatePicker: true,
            timePicker: true,
            locale: {
                format: 'Y-M-DD hh:mm A'
            }
        });

        if ($('#exam_type').val() == 1) {
            $('.exam_price_content').removeClass('d-none').addClass('d-block');
        } else {
            $('.exam_price_content').removeClass('d-block').addClass('d-none');
        }
        $('#exam_type').on('change', function() {
            if ($(this).val() == 1) {
                $('.exam_price_content').removeClass('d-none').addClass('d-block');
            } else {
                $('.exam_price_content').removeClass('d-block').addClass('d-none');
            }
        })

        CKEDITOR.replace('description');

    </script>
@endsection
