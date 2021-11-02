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
                                <li class="breadcrumb-item active" aria-current="page">All Courses</li>
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
                                    <h4>All Courses</h4>
                                </div>
                                <div class="dashboard_fl_2">
                                    <ul class="mb0">
                                        <li class="list-inline-item">

                                        </li>
                                        <li class="list-inline-item">
                                            <form class="form-inline my-2 my-lg-0">
                                                <input class="form-control" type="search" placeholder="Search Courses"
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
                                @foreach ($enrolls as $enroll)
                                @foreach ($enroll->packages as $item)
                                <div class="dashboard_single_course">
                                    <div class="dashboard_single_course_thumb">
                                        <img src="{{ asset(''. $item->photo) }}" class="img-fluid" alt="" />
                                        <div class="dashboard_action">
                                            <a href="{{ route('package.details', [$item->id, $item->slug]) }}"
                                                class="btn btn-ect">View</a>
                                        </div>
                                    </div>
                                    <div class="dashboard_single_course_caption">
                                        <div class="dashboard_single_course_head">
                                            <div class="dashboard_single_course_head_flex">
                                                <span
                                                    class="dashboard_instructor">{{ word_view($item->user ? $item->user->name : 'Unknown') }}</span>
                                                <h4 class="dashboard_course_title">{{ $item->title }}</h4>
                                                @php
                                                $rate = $item->reviews->count() > 0 ?
                                                round($item->reviews->sum('rating') / $item->reviews->count(), 2) : 0
                                                @endphp
                                                <div class="dashboard_rats">
                                                    <div class="dashboard_rating">
                                                        @php
                                                        for ($i=0; $i <5 ; $i++) { echo '<i class="' ,( $rate <=$i?'
                                                            ti-star ':' ti-star filled'),'"></i>';
                                                            }
                                                            @endphp
                                                    </div>
                                                    <span>({{ $item->reviews->count() }} Reviews)</span>
                                                </div>
                                            </div>
                                            <div class="dc_head_right">
                                                <h4 class="dc_price_rate theme-cl"> {!! $item->package_type == 0 ?
                                                    ''.word_view('free').'' :
                                                    ''.currency_type($item->sale_price).'
                                                    <del>'.currency_type($item->org_price).'</del>'
                                                    !!}</h4>
                                            </div>
                                        </div>
                                        <div class="dashboard_single_course_des">
                                            <p>{!! limit_string($item->description, 100)!!}</p>
                                        </div>
                                        <div class="dashboard_single_course_progress">
                                            @php
                                            $mcqs = $item->mcqs->count();
                                            $ids = $item->mcqs->pluck('id');
                                            $com= 0;
                                            foreach ($ids as $id) {
                                            $get = App\Models\McqUserAnswer::where('main_mcq_id', $id)->where('user_id',
                                            auth()->id())->first();
                                            if ($get) {
                                            $com +=1;
                                            }
                                            }
                                            @endphp
                                            <div class="dashboard_single_course_progress_1">
                                                <label>{{ round($com != 0 ? $com * 100 / $mcqs : 0, 2)}}% Completed</label>
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-striped bg-success"
                                                        role="progressbar" style="width: {{ round($com != 0 ? $com * 100 / $mcqs : 0, 2)}}%" aria-valuenow="{{ round($com != 0 ? $com * 100 / $mcqs : 0, 2)}}"
                                                        aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="dashboard_single_course_progress_2">
                                                <ul class="m-0">
                                                    <li class="list-inline-item"><i
                                                            class="ti-user mr-1"></i>{{ $item->enrolls->count() }}
                                                        Enrolled</li>
                                                    <li class="list-inline-item"><i
                                                            class="ti-comment-alt mr-1"></i>{{ $item->reviews->count() }}
                                                        Comments</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endforeach

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
