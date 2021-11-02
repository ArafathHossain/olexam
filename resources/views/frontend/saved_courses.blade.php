@extends('layouts.frontend')
@section('content')

<!-- ============================ Dashboard: My Order Start ================================== -->
<section class="gray pt-0">
    <div class="container-fluid">

        <!-- Row -->
        <div class="row">

            @include('partials.student_dashboard_sidebar')

            <div class="col-lg-9 col-md-9 col-sm-12">

                <!-- Row -->
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 pt-4 pb-4">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Saved Courses</li>
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
                                    <h4>Wishlist Courses</h4>
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
                                @foreach ($my_wishlist as $package)
                                <div class="dashboard_single_course">
                                    <div class="dashboard_single_course_thumb">
                                        <img src="{{ asset(''. $package->photo) }}" class="img-fluid" alt="" />
                                        <div class="dashboard_action circle">
                                            <a href="{{ route('package.details', [$package->id, $package->slug]) }}"
                                                class="btn btn-ect view"><i class="ti-eye"></i></a>
                                            <form action="{{ route('remove.wishlist') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $package->id }}">
                                                <button type="submit" class="btn btn-ect delete"><i
                                                        class="ti-trash"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="dashboard_single_course_caption">
                                        <div class="dashboard_single_course_head">
                                            <div class="dashboard_single_course_head_flex">
                                                <span class="dashboard_instructor">Adam Wilson</span>
                                                <h4 class="dashboard_course_title">
                                                    {{ $package->class ? $package->class->name : '' }} -
                                                    {{ $package->subject ? $package->subject->name : '' }} - {!!
                                                    $package->title !!}
                                                </h4>
                                                <div class="dashboard_rats">
                                                    <div class="dashboard_rating">
                                                        @php
                                                        $review_count = $package->reviews->count();
                                                        $rate = $review_count > 0 ?
                                                        round($package->reviews->sum('rating') /
                                                        $review_count,
                                                        2) : 0;
                                                        for ($i=0; $i <5 ; $i++) { echo '
                                                            <i class="' ,( $rate <=$i?' ti-star ':' ti-star
                                                            filled'),'"></i>
                                                            ';
                                                            }
                                                            @endphp
                                                    </div>
                                                    <span>({{ $review_count }} Reviews)</span>
                                                </div>
                                            </div>
                                            <div class="dc_head_right">
                                                <h4 class="dc_price_rate theme-cl">{!! $package->package_type == 0 ?
                                                    ''.word_view('free').'' :
                                                    ''.currency_type($package->sale_price).'
                                                    <del>'.currency_type($package->org_price).'</del>'
                                                    !!}</h4>
                                            </div>
                                        </div>
                                        <div class="dashboard_single_course_des">
                                            <p>{!! limit_string($package->description, 300)!!}</p>
                                        </div>
                                        <div class="dashboard_single_course_progress">
                                            <div class="dashboard_single_course_progress_2">
                                                <ul class="m-0">
                                                    <li class="list-inline-item"><i
                                                            class="ti-user mr-1"></i>{{ $package->enrolls->count() }}
                                                        Enrolled</li>
                                                    <li class="list-inline-item"><i
                                                            class="ti-comment-alt mr-1"></i>{{ $review_count }}
                                                        Comments</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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

<!-- ============================================================== -->
<!-- This page plugins -->
<!-- ============================================================== -->


@endsection
@section('js')
<script src="{{ asset('js/metisMenu.min.js') }}"></script>
@endsection
@section('custom_js')
<script>
    $('#side-menu').metisMenu();

</script>
@endsection
