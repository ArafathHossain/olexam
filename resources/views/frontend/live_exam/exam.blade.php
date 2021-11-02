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
        {{-- <div id="count"></div> --}}
        <form action="{{ route('live.exam.submit') }}" method="POST" id="mcq_submit_form">
            <div class="row">
                <div class="col-md-8 mx-auto pt-5">
                    <div class="card">
                        <div id="test"></div>
                        <h2 class="p-2">Exam Time Left: <span class="text-danger" id="count"></span></h2>
                    </div>
                    @php
                    $row_mcq = json_decode($mcq->row_mcq);
                    $row_mcq = arr_shuffle($row_mcq);
                    $sl_num = 1;
                    @endphp
                    @csrf
                    @foreach ($row_mcq as $mcq_item)
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                @if ($mcq_item->select_type == 'only_paragraph_5')
                                <div>{!! $mcq_item->questions_title !!}</div>
                                @else
                                @if ($mcq_item->questions_photo == '')
                                <h3 class="card-title d-flex">
                                    <div class="pr-2 pt-2">{{ $sl_num++ }}. </div>
                                    <div>{!! $mcq_item->questions_title !!}</div>
                                </h3>
                                @else
                                <div>
                                    <h3 class="card-title">
                                        {!! $mcq_item->questions_title !!}
                                    </h3>
                                    <img class="img-fluid mb-3" width="80%"
                                        src="{{ asset('' . $mcq_item->questions_photo) }}" alt="">
                                </div>
                                @endif
                                <span>{{ $mcq_item->points }} points</span>
                                @endif
                            </div>
                            <div class="form-group">
                                @if ($mcq_item->select_type == 'shot_questions_1')
                                <input type="text" class="form-control "
                                    id="{{ mcq_type_other($mcq_item->select_type, $mcq_item->field_id) }}"
                                    name="{{ $mcq_item->field_id }}" placeholder="Your Answer">
                                @elseif($mcq_item->select_type == 'paragraph_questions_2')
                                <textarea type="text" class="form-control " rows="2"
                                    id="{{ mcq_type_other($mcq_item->select_type, $mcq_item->field_id) }}"
                                    name="{{ $mcq_item->field_id }}" placeholder="Your Answer">
                                        </textarea>
                                @elseif($mcq_item->select_type == 'multiple_questions_3')
                                @foreach ($mcq_item->options as $option)
                                <div class="checkbox checkbox-success">
                                    <div>
                                        <input type="radio" name="{{ $mcq_item->field_id }}"
                                            id="{{ mcq_type_checkbox($option->option_id, $mcq_item->field_id) }}"
                                            value="{{ $option->option_id }}">
                                        <label
                                            for="{{ mcq_type_checkbox($option->option_id, $mcq_item->field_id) }}">{{ $option->input_name }}</label>
                                    </div>
                                    <div>
                                        <img class="pb-3 img-fluid" src="{{ asset('' . $option->input_photo) }}" alt="">
                                    </div>
                                </div>
                                @endforeach
                                @elseif($mcq_item->select_type == 'file_questions_4')
                                <div class="">
                                    <input type="file" name="{{ $mcq_item->field_id }}"
                                        id="{{ mcq_type_other($mcq_item->select_type, $mcq_item->field_id) }}"
                                        class="custom-input-file custom-input-file--2">
                                    <label for="{{ mcq_type_other($mcq_item->select_type, $mcq_item->field_id) }}">
                                        <i class="fa fa-upload"></i>
                                        <span>Upload Your scratch</span>
                                    </label>
                                </div>
                                @endif

                            </div>
                        </div>
                    </div>
                    @endforeach
                    <input type="hidden" name="mcq_id" value="{{ $mcq->id }}">
                    <input type="hidden" name="mcq_sl" value="{{ $mcq->sl }}">
                    <input type="hidden" name="live_exam_id" value="{{ $liveexam->id }}">
                    <div class="red-skin ">
                        <button type="submit" class="btn btn-theme">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<!-- ====================================== FAQS =================================== -->
@endsection
@section('custom_js')
<script language="javascript">
    window.onbeforeunload = function(e) {
            return 'You application form is not submitted yet.';
        };
        document.getElementById("mcq_submit_form").onsubmit = function(e) {
            window.onbeforeunload = null;
            return true;
        };

        function countdown(elementName, minutes, seconds) {
            var element, endTime, hours, mins, msLeft, time;

            function twoDigits(n) {
                return (n <= 9 ? "0" + n : n);
            }

            function updateTimer() {
                msLeft = endTime - (+new Date);
                if (msLeft < 1000) {
                    element.innerHTML = "Time is up!";
                    document.getElementById('mcq_submit_form').submit();
                    // alert('out')
                } else {
                    time = new Date(msLeft);
                    hours = time.getUTCHours();
                    mins = time.getUTCMinutes();
                    element.innerHTML = (hours ? hours + ':' + twoDigits(mins) : mins) + ':' + twoDigits(time
                        .getUTCSeconds());
                    setTimeout(updateTimer, time.getUTCMilliseconds() + 500);
                }
            }

            element = document.getElementById(elementName);
            endTime = (+new Date) + 1000 * (60 * minutes + seconds) + 500;
            updateTimer();
        }
        var time = '{{ $mcq->time ? $mcq->time : 60 }}';
        countdown("count", parseInt(time), 0);

</script>
@endsection