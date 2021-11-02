@extends('layouts.frontend')
@section('custom_css')
<style>
    .all_live_exam .exam_content {
        padding-bottom: 30px;
    }

    .all_live_exam .exam_img {
        width: 220px;
        height: 200px;
    }

    .all_live_exam .exam_img img {
        position: relative;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .all_live_exam .exam_title {
        font-size: 20px;
    }



    .all_live_exam .exam_time {
        padding-bottom: 10px;
    }

    .all_live_exam .exam_class {
        padding-bottom: 10px;
    }

    .all_live_exam .btn {
        display: inline-block;
        border-radius: 4px;
        padding: 10px 20px;
        margin-top: 20px;
    }

    .all_live_exam .btn:hover {
        color: #fff;
    }
</style>
@endsection
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
                                <li class="breadcrumb-item active" aria-current="page">All Live Exam</li>
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
<section class=" bg-light all_live_exam red-skin">
    <div class="container">
        <div class="row">
            @foreach ($exams as $exam)


                <div class="singles_items">
                    <div class="education_block_grid style_2">
                        <div class="education_block_thumb n-shadow">
                            <a href="{{ route('exam.details', [$exam->id]) }}"><img
                                    src="/images/exam.jpg" class="img-fluid" alt=""></a>
                            <div class="cources_price">{!! ((int) $exam->exam_type) ?
                                    '<span>'.currency_type($exam->price).'</span>' : 'Free' !!}</div>
                        </div>

                        <div class="education_block_body">
                            <h4 class="bl-title"><a
                                    href="{{ route('exam.details', [$exam->id]) }}">{!!
                                        word_view($exam->title) !!}</a></h4>
                        </div>
                        @php
                            $date = $exam->start_time;
                            $date_end = $exam->end_time;
                        @endphp
                        <div class="cources_info_style3">
                            <ul class="d-flex justify-content-between">
                                <li>
                                    @if ($date->isToday())
                                        <span>{{ format_date_time($exam->start_time, 'h:i A') }}</span>
                                        To
                                        <span>{{ format_date_time($exam->end_time, 'h:i A') }}</span>
                                    @else
                                        <span>{{ $date->diffForHumans() }}</span>
                                        To
                                        <span>{{ $date_end->diffForHumans() }}</span>
                                    @endif
                                </li>
                                <li>{{ word_view($exam->class->name) }}</li>
                            </ul>
                        </div>

{{--                        <div class="education_block_footer">--}}
{{--                            <div class="education_block_author">--}}
{{--                                <div class="path-img"><img src="{{ $package->user->photo ?? asset('images/user-1.jpg')}}" class="img-fluid"--}}
{{--                                                           alt="">--}}
{{--                                </div>--}}
{{--                                <h5>{{ $package->user->name ?? 'Unknown' }}</h5>--}}
{{--                            </div>--}}
{{--                            <div class="foot_lecture"><i--}}
{{--                                    class="ti-control-skip-forward mr-2"></i>{{ $package->user ? $package->user->packages->count() : 0 }}--}}
{{--                                lectures</div>--}}
{{--                        </div>--}}
                    </div>
                </div>

{{--            <div class="col-md-6" id="exam-{{ $exam->id }}">--}}
{{--                <div class="d-flex exam_content">--}}
{{--                    <div class="exam_img">--}}
{{--                        <img src="/images/exam.jpg" alt="" class="img-fluid">--}}
{{--                    </div>--}}
{{--                    <div class="d-flex flex-column pl-4 ">--}}
{{--                        <h2 class="exam_title">{{ $exam->title }}</h2>--}}
{{--                        @php--}}
{{--                        $date = $exam->start_time;--}}
{{--                        $date_end = $exam->end_time;--}}
{{--                        @endphp--}}
{{--                        <div class="exam_time">--}}
{{--                            @if ($date->isToday())--}}
{{--                            <span>{{ format_date_time($exam->start_time, 'h:i A') }}</span>--}}
{{--                            To--}}
{{--                            <span>{{ format_date_time($exam->end_time, 'h:i A') }}</span>--}}
{{--                            @else--}}
{{--                            <span>{{ $date->diffForHumans() }}</span>--}}
{{--                            To--}}
{{--                            <span>{{ $date_end->diffForHumans() }}</span>--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                        @if ($exam->class)--}}
{{--                        <span class="exam_class">Class: {{ word_view($exam->class->name) }}</span>--}}
{{--                        @endif--}}
{{--                        @if ($exam->enroll()->where('user_id', auth()->id())->first())--}}
{{--                        <a href="{{ $date->isToday() ? route('exam.page', $exam->id) : '#' }}"--}}
{{--                            class="btn btn-theme ">{{ $date->isToday() ? 'Exam' : 'Coming Soon' }}</a>--}}
{{--                        @else--}}
{{--                            @if((int) $exam->exam_type)--}}
{{--                                @php--}}
{{--                                    $payLink = Auth::user()->charge($exam->price, 'Enrollment', [--}}
{{--                                        "passthrough" => [--}}
{{--                                            'enrollment_type' => 'live_exam',--}}
{{--                                            'live_exam_id' => $exam->id--}}
{{--                                        ]--}}
{{--                                    ]);--}}
{{--                                @endphp--}}
{{--                                <x-paddle-button :url="$payLink" class="btn checkout_btn w-100" data-theme="none">--}}
{{--                                    Purchase Live Exam--}}
{{--                                </x-paddle-button>--}}
{{--                            @else--}}
{{--                            <form action="{{ url('/checkout/live_enroll') }}" method="post">--}}
{{--                                @csrf--}}
{{--                                <input type="hidden" name="live_id" value="{{ $exam->id }}">--}}
{{--                                <button type="submit" class="btn btn-theme " > Enroll--}}
{{--                                </button>--}}
{{--                            </form>--}}
{{--                            @endif--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
            @endforeach

        </div>
    </div>
</section>
<!-- ====================================== FAQS =================================== -->
@endsection
@section('custom_js')

@endsection
