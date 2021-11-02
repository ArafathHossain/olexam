@extends('layouts.admin')

@section('page_header')
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active"> MCQ</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-spiral"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold"> MCQ</h1>
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
                <h6 class="fs-17 font-weight-600 mb-0"> MCQ</h6>
            </div>
            {{-- <h3>Auto redirect after <span id="timecount"></span> second(s)!</h3> --}}
            <div class="text-right">
                <div class="actions">
                    <a href="{{ route('admin.main-mcqs.index') }}" class="action-item"><i
                            class="fas fa-angle-left mr-2"></i>Back</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.get_data') }}" enctype="multipart/form-data">
                @csrf
                <div class="col-md-12">
                    <div class="col-md-6 mx-auto">
                        @php
                        $mcqs = json_decode($mcq->row_mcq);
                        @endphp
                        @foreach ($mcqs as $mc)
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <input type="hidden" name="mcq_id" value="{{ $mcq->id }}">
                                    <input type="hidden" name="mcq_sl" value="{{ $mcq->sl }}">
                                    <input type="hidden" name="mcq_title" value="{{ $mcq->title }}">
                                    @if ($mc->questions_photo == "")
                                    <div>
                                        {!! $mc->questions_title !!}
                                    </div>

                                    @else
                                    <div>
                                        <div>
                                            {!! $mc->questions_title !!}
                                        </div>

                                        <img class="img-fluid mb-3" width="80%"
                                            src="{{ asset(''.$mc->questions_photo) }}" alt="">
                                    </div>
                                    @endif
                                    <span>{{ $mc->points }} points</span>
                                </div>
                                <div class="form-group">
                                    @if ($mc->select_type == 'shot_questions_1')
                                    <input type="text" class="form-control "
                                        id="{{ mcq_type_other($mc->select_type, $mc->field_id) }}"
                                        name="{{$mc->field_id}}" placeholder="Your Answer">
                                    @elseif($mc->select_type == 'paragraph_questions_2')
                                    <textarea type="text" class="form-control " rows="2"
                                        id="{{ mcq_type_other($mc->select_type, $mc->field_id) }}"
                                        name="{{$mc->field_id}}" placeholder="Your Answer">
                                    </textarea>
                                    @elseif($mc->select_type == 'multiple_questions_3')
                                    @foreach ($mc->options as $option)
                                    <div class="checkbox checkbox-success">
                                        <div>
                                            <input type="checkbox" name="{{$mc->field_id}}[]"
                                                id="{{ mcq_type_checkbox($option->option_id, $mc->field_id) }}"
                                                value="{{ mcq_type_checkbox($option->option_id, $mc->field_id) }}">
                                            <label
                                                for="{{mcq_type_checkbox($option->option_id, $mc->field_id)}}">{{ $option->input_name }}</label>
                                        </div>
                                        <div>
                                            <img class="pb-3 img-fluid" src="{{ asset(''.$option->input_photo) }}"
                                                alt="">
                                        </div>
                                    </div>
                                    @endforeach
                                    @elseif($mc->select_type == 'file_questions_4')
                                    <div class="">
                                        <input type="file" name="{{$mc->field_id}}"
                                            id="{{ mcq_type_other($mc->select_type, $mc->field_id) }}"
                                            class="custom-input-file custom-input-file--2">
                                        <label for="{{ mcq_type_other($mc->select_type, $mc->field_id) }}">
                                            <i class="fa fa-upload"></i>
                                            <span>Upload Your scratch</span>
                                        </label>
                                    </div>
                                    @endif
                                    {{-- <input type="hidden" name="question_id[]"
                                        value="{{ $mc->field_id }}"> --}}
                                    {{-- <input type="hidden" name="question_id_{{ $mc->field_id }}"
                                    value="{{ $mc->field_id }}"> --}}
                                </div>
                            </div>
                        </div>
                        @endforeach
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
    <script src="{{ asset('admin/assets/dist/js/pages/forms-basic.active.js') }}"></script>
    @endsection
    @section('custom_js')
    {{-- <script type="text/javascript">
        var time = 300; // Time coutdown
        var page = "http://www.redirect-url.com/";

        function countDown() {
            time--;
            gett("timecount").innerHTML = time;
            if (time == -1) {
                window.location = page;
            }
        }

        function gett(id) {
            if (document.getElementById) return document.getElementById(id);
            if (document.all) return document.all.id;
            if (document.layers) return document.layers.id;
            if (window.opera) return window.opera.id;
        }

        function init() {
            if (gett('timecount')) {
                setInterval(countDown, 1000);
                gett("timecount").innerHTML = time;
            } else {
                setTimeout(init, 50);
            }
        }
        document.onload = init();

    </script> --}}
    @endsection
