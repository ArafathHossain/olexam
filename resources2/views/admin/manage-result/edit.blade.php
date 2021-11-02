@extends('layouts.admin')
@section('css')
<link href="{{ asset('css/styles.css')}}" rel="stylesheet">
<style>
    .checked[type="radio"]:checked+label:after {
        background: #2ea033 !important;
    }

    .checked_ans[type="radio"]:checked+label:after {
        background: #2ea033 !important;
    }

</style>
@endsection
@section('page_header')
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Review Exam</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-spiral"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Review Exam</h1>
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
                <h6 class="fs-17 font-weight-600 mb-0">Review Exam</h6>
            </div>
            <div class="text-right">
                <div class="actions">
                    <a href="{{ route('admin.manage.exam') }}" class="action-item"><i
                            class="fas fa-angle-left mr-2"></i>Back</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.exam.set.result', $exam->id) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-8 mx-auto pt-5">
                        <div class="card ">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="pt-2 pl-2">Total Points : <span
                                        class="font-weight-bold">{{ $ans_mcq->sum('answer_points') }}</span></h3>
                                <h3 class="pt-2 pr-2">Your Points : <span
                                        class="font-weight-bold">{{ $user_ans->sum('points') }}</span></h3>
                            </div>
                        </div>
                        @php
                        $row_mcq = json_decode($main_mcq->row_mcq);
                        @endphp
                        @foreach ($row_mcq as $mcq_item)
                        <div class="card">
                            @php
                            $user = '';
                            $ans = $ans_mcq->where('question_id', $mcq_item->field_id)->first() ?
                            $ans_mcq->where('question_id', $mcq_item->field_id)->first()->answers : '';

                            $user = $user_ans->where('question_id', $mcq_item->field_id)->first() ?
                            $user_ans->where('question_id', $mcq_item->field_id)->first()->answers : '';

                            $id = $user_ans->where('question_id', $mcq_item->field_id)->first() ?
                            $user_ans->where('question_id', $mcq_item->field_id)->first()->id : '';
                            
                            $points = $user_ans->where('question_id', $mcq_item->field_id)->first() ?
                            $user_ans->where('question_id', $mcq_item->field_id)->first()->points : '';
                            @endphp
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    @if ($mcq_item->select_type == 'only_paragraph_5')
                                    <div class="w-100">{!! $mcq_item->questions_title !!}</div>
                                    @else
                                    @if ($mcq_item->questions_photo == "")
                                    <h3 class="card-title">
                                        {!! $mcq_item->questions_title !!}
                                    </h3>
                                    @else
                                    <div>
                                        <h3 class="card-title">
                                            {!! $mcq_item->questions_title !!}
                                        </h3>
                                        <img class="img-fluid mb-3" width="80%"
                                            src="{{ asset(''.$mcq_item->questions_photo) }}" alt="">
                                    </div>
                                    @endif
                                    <span>{{ $mcq_item->points }} points</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    @if ($mcq_item->select_type == 'shot_questions_1')
                                    <input type="text"
                                        class="form-control {{ !empty($user) ?  ( in_array($user, explode('||', $ans)) ? 'bg-success text-light' : 'bg-danger text-light') :' bg-danger text-light' }}"
                                        readonly value=" {{ $user }}">
                                    <span class="pt-2 d-inline-block">
                                        Correct Answer : <span class="font-weight-bold">{{ $ans }}</span>
                                    </span>
                                    @elseif($mcq_item->select_type == 'paragraph_questions_2')
                                    <textarea type="text" class="form-control " rows="2"
                                        readonly>{{ $user }} </textarea>
                                    <span class="pt-2 d-inline-block">
                                        Correct Answer : <span class="font-weight-bold">{{ $ans }}</span>

                                        @elseif($mcq_item->select_type == 'multiple_questions_3')

                                        @foreach ($mcq_item->options as $option)
                                        <div class="checkbox checkbox-success ">
                                            <div>
                                                <input type="radio" value="{{$option->option_id}}"
                                                    {{ $user == $option->option_id ? 'checked' : '' }}
                                                    {{ ($user != $ans && $ans == $option->option_id) ? 'checked ' : '' }}
                                                    class="{{ ($user != $ans && $ans == $option->option_id) ? 'checked ' : '' }}
                                                     {{ ($user == $ans && $ans == $option->option_id) ? 'checked_ans ' : '' }}">
                                                <label class="" style="">{{ $option->input_name }}</label>
                                            </div>
                                            <div>
                                                <img class="mb-3 img-fluid" src="{{ asset(''.$option->input_photo) }}"
                                                    alt="">
                                            </div>
                                        </div>
                                        @endforeach
                                        @elseif($mcq_item->select_type == 'file_questions_4')
                                        <div class="">
                                            <input type="file" class="custom-input-file custom-input-file--2">
                                            <label>
                                                <i class="fa fa-upload"></i>
                                                <span>Upload Your scratch</span>
                                            </label>
                                        </div>
                                        @endif
                                </div>
                                @if (!empty($mcq_item->answer_review) )
                                <button type="submit" class="btn btn-outline-theme  float-right answer_review"
                                    data-toggle="popover" data-placement="top"
                                    data-content="{{ $mcq_item->answer_review  }}">Review
                                    Answers</button>
                                @endif
                            </div>
                            <div class="card-footer p-1 px-4">
                                <div class="form-group">
                                    <label for="">Set Points</label>
                                    <input type="text" class="form-control" name="{{ $id }}" value="{{ $points }}">
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <input type="hidden" name="exam_id" value="{{ $exam->id }}">
                    </div>
                    <div class="col-md-12">
                        <div class="text-center">
                            <button type="submit" class="btn btn-info">Update</button>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection
@section('js')
{{-- <script src="{{ asset('admin/assets/plugins/select2/dist/js/select2.min.js')}}"></script> --}}
<script src="{{ asset('admin/assets/plugins/jquery.sumoselect/jquery.sumoselect.min.js')}}"></script>
@endsection
@section('custom_js')
<script>
    $('.select2').SumoSelect({
        selectAll: true,
        search: true
    });

</script>
@endsection
