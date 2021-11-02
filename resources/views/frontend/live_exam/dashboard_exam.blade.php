@extends('layouts.frontend')
@section('content')
    <!-- ============================ Dashboard: My Order Start ================================== -->
    <section class="gray pt-0">
        <div class="container-fluid">
            <div class="row">

                @include('partials.student_dashboard_sidebar')

                <div class="col-lg-9 col-md-9 col-sm-12">

                    <!-- Row -->
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 pt-4 pb-4">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Live Exams</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!-- /Row -->

                    <!-- Row -->
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">

                            <!-- Course Style 1 For Student -->
                            <div class="dashboard_container">
                                <div class="dashboard_container_header">
                                    <div class="dashboard_fl_1">
                                        <h4>All Exams</h4>
                                    </div>
                                    <div class="dashboard_fl_2">
                                        <ul class="mb0">
                                            <li class="list-inline-item">

                                            </li>
                                            <li class="list-inline-item">
                                                <form class="form-inline my-2 my-lg-0">
                                                    <input class="form-control" type="search" placeholder="Search Live Exam"
                                                           aria-label="Search">
                                                    <button class="btn my-2 my-sm-0" type="submit"><i
                                                            class="ti-search"></i></button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="dashboard_container_body">
                                    <!-- Single Course -->
                                    <div class="row">
                                        @foreach ($exams as $exam)

                                            <div class="col-md-6" id="exam-{{ $exam->id }}">
                                                <div class="d-flex exam_content">
                                                    <div class="exam_img">
                                                        <img src="/images/exam.jpg" alt="" class="img-fluid">
                                                    </div>
                                                    <div class="d-flex flex-column pl-4 ">
                                                        <h2 class="exam_title">{{ $exam->title }}</h2>
                                                        @php
                                                            $date = $exam->start_time;
                                                            $date_end = $exam->end_time;
                                                        @endphp
                                                        <div class="exam_time">
                                                            @if ($date->isToday())
                                                                <span>{{ format_date_time($exam->start_time, 'h:i A') }}</span>
                                                                To
                                                                <span>{{ format_date_time($exam->end_time, 'h:i A') }}</span>
                                                            @else
                                                                <span>{{ $date->diffForHumans() }}</span>
                                                                To
                                                                <span>{{ $date_end->diffForHumans() }}</span>
                                                            @endif
                                                        </div>
                                                        @if ($exam->class)
                                                            <span class="exam_class">Class: {{ word_view($exam->class->name) }}</span>
                                                        @endif
                                                        <a href="{{ $date_end->lte(now()) ? route('exam.page', $exam->id) : '#' }}"
                                                           class="btn btn-theme ">{{ $date_end->lte(now()) ? 'See Result' : 'Result Not Published' }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- /Row -->

                </div>

            </div>
            <!-- Row -->

        </div>
    </section>
    <!-- ============================ Dashboard: My Order Start End ================================== -->
@endsection
@section('js')
    <script src="{{ asset('js/metisMenu.min.js') }}"></script>
@endsection
@section('custom_js')
    <script>
        $('#side-menu').metisMenu();

    </script>
@endsection
