@extends('layouts.frontend')
@section('custom_css')
    <style>
        .review-form-box-star ul li {
            padding: 0px 3px;
        }

        .review-form-box-star ul li i {
            color: #838d9c;
            font-size: 12px;
        }

        .review-form-box-star ul li.hover i,
        .review-form-box-star ul li.selected i {
            color: #DA0B4E;
        }

        .mcq_video_icon i {
            font-size: 20px;
            width: 30px;
            height: 30px;
            font-family: "themify";
            background: rgba(76, 175, 80, 0.12);
            right: 60px;
            top: 15px;
            position: absolute;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #4caf50;
        }

        .card[class^="card-name-"] {
            display: none;
        }
    </style>
@endsection
@section('content')
    <!-- ============================ Course header Info Start================================== -->
    <div class="ed_detail_head lg bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mb-3">
                    <h2>{{ ($exam->class) ? word_view($exam->class->name) : '' }} - {!! $exam->title !!}</h2>
                </div>
            </div>
            <div class="row align-items-center">

                <div class="col-lg-6 col-md-6">
                    <div class="ed_detail_wrap">
                        <ul class="list_ed_detail2">
                            <li class="tag-1"><i
                                    class="ti-user"></i><strong>Enrolled:</strong>{{ $enroll_count }}
                                Students
                            </li>
                            <li class="tag-4"><i
                                    class="ti-tag"></i><strong>Level:</strong>{{ $exam->class ? $exam->class->name : '' }}
                            </li>
                        </ul>
                    </div>
                    <div class="ed_view_link mt-3">
                        @if (!$is_enrolled)
                            @if (!(int) $exam->exam_type)
                                <form action="{{ url('/checkout/live_enroll') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="live_id" value="{{ $exam->id }}">
                                    <button type="submit" class="btn btn-theme "> Enroll
                                    </button>
                                </form>
                            @else
                                @php
                                    $payLink = Auth::user()->charge($exam->price, 'Enrollment', [
                                                                    "passthrough" => [
                                                                        'enrollment_type' => 'live_exam',
                                                                        'live_exam_id' => $exam->id
                                                                    ]
                                    ]);
                                @endphp
                                <x-paddle-button :url="$payLink" class="btn checkout_btn w-100" data-theme="none">
                                    Purchase Live Exam
                                </x-paddle-button>
                            @endif
                        @else
                            @php
                            $date = $exam->start_time;
                            @endphp
                            <a href="{{ $date->isToday() ? route('exam.page', $exam->id) : '#' }}" class="btn btn-theme ">
                                {{ $date->isToday() ? 'Goto Exam' : 'Coming Soon' }}
                            </a>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="property_video lg">
                        <div class="thumb">
                            <img class="pro_img img-fluid w100" src="/images/exam.jpg" alt="7.jpg">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- ============================ Course Header Info End ================================== -->

    <!-- ============================ Course Detail ================================== -->
    <section>
        <div class="container">
            <div class="row">

                <div class="col-lg-8 col-md-8">


                    <div class="edu_wraper border">
                        <h4>Description</h4>
                        {!! $exam->description !!}
                    </div>

                    {{-- structor  --}}
                    <div class="single_instructor border">
                        <div class="single_instructor_thumb">
                            <a href="#"><img src="{{ asset($exam->user->photo ?? 'images/user-3.jpg') }}"
                                             class="img-fluid" alt=""></a>
                        </div>
                        <div class="single_instructor_caption">
                            <h4><a href="#">{{ $exam->user->name ?? '' }}</a></h4>
                            <p>{!! $exam->user->about ?? '' !!}</p>

                        </div>
                    </div>


                </div>

                <!-- Sidebar -->
                <div class="col-lg-4 col-md-4">

                    <div class="ed_view_box style_2 border">

                    <!-- <div class="ed_author">
                        <div class="ed_author_thumb">
                            <img class="img-fluid"
                                src="/{{ $exam->user->photo ? $exam->user->photo : 'images/user/user.png' }}"
                                alt="7.jpg">
                        </div>
                        <div class="ed_author_box">
                            <h4>{{ $exam->user ? $exam->user->name : '' }}</h4>
                        </div>
                    </div> -->

                        <div class="ed_view_price pl-4 mt-3">
                            <span>Acctual Price</span>
                            @if ((int) $exam->exam_type)
                                <h2 class="theme-cl">
                                    <div class="d-inline-block">{{ currency_type($exam->price) }}
                                    </div>
                                </h2>
                            @else
                                <h2 class="theme-cl">
                                    <div class="d-inline-block">Free</div>
                                </h2>
                            @endif
                        </div>
                        <div class="ed_view_features pl-4">
                            <!-- <span>Course Features</span> -->
                            <ul>
                                @if ($exam->features != '')
                                    @php
                                        $features = explode('||', $exam->features);
                                    @endphp
                                    @foreach ($features as $fea)
                                        <li><i class="ti-angle-right"></i>{{ $fea }}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </section>
    <!-- ============================ exam Detail ================================== -->


    <!-- ============================ Full Width Courses End ================================== -->
@endsection
@section('custom_js')
    <script>


    </script>
@endsection
