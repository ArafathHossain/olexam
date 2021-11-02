@extends('layouts.frontend')
@section('content')
<!-- ============================ Page Title Start================================== -->
<section class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 pt-4 pb-4">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Exam</li>
                            </ol>
                        </nav>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<!-- ============================ Page Title End ================================== -->

<!-- =================================== FAQS =================================== -->
<section class="pt-0 bg-light">
    <div class="container">
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
                    $ans = $ans_mcq->where('question_id', $mcq_item->field_id)->first() ? $ans_mcq->where('question_id', $mcq_item->field_id)->first()->answers : '';
                    $user = $user_ans->where('question_id', $mcq_item->field_id)->first() ?
                    $user_ans->where('question_id', $mcq_item->field_id)->first()->answers : '';
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
                                <img class="img-fluid mb-3" width="80%" src="{{ asset(''.$mcq_item->questions_photo) }}"
                                    alt="">
                            </div>
                            @endif
                            <span>{{ $mcq_item->points }} points</span>
                            @endif
                        </div>
                        <div class="form-group">
                            @if ($mcq_item->select_type == 'shot_questions_1')
                            <input type="text"
                                class="form-control {{ !empty($user) ?  ($user == $ans ? 'bg-success text-light' : 'bg-danger text-light') :' bg-danger text-light' }}"
                                readonly value=" {{ $user }}">
                            <span class="pt-2 d-inline-block">
                                Correct Answer : <span class="font-weight-bold">{{ $ans }}</span>
                            </span>
                            @elseif($mcq_item->select_type == 'paragraph_questions_2')
                            <textarea type="text" class="form-control " rows="2" readonly>{{ $user }} </textarea>
                            <span class="pt-2 d-inline-block">
                                Correct Answer : <span class="font-weight-bold">{{ $ans }}</span>

                                @elseif($mcq_item->select_type == 'multiple_questions_3')
                                <style>
                                    .checked[type="radio"]:checked+label:after {
                                        background: #2ea033;
                                    }

                                    .checked_ans[type="radio"]:checked+label:after {
                                        background: #2ea033;
                                    }
                                </style>
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
                                        <img class="mb-3 img-fluid" src="{{ asset(''.$option->input_photo) }}" alt="">
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
                        {{-- {{ print_r($mcq_item) }} --}}
                        @if (!empty($mcq_item->answer_review) )
                        <button type="submit" class="btn btn-outline-theme  float-right answer_review"
                            data-toggle="popover" data-placement="top"
                            data-content="{{ $mcq_item->answer_review  }}">Review
                            Answers</button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- ====================================== FAQS =================================== -->
@endsection
@section('custom_js')
<script>
    $('.answer_review').popover({
    container: 'body'
  })
</script>
@endsection
