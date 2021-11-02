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
                                <li class="breadcrumb-item active" aria-current="page">My Profile</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!-- /Row -->

                <!-- Row -->
                <div class="row align-items-center">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="dashboard_container">
                            <div class="dashboard_container_body p-4">
                                <div class="viewer_detail_wraps">
                                    <div class="viewer_detail_thumb">
                                        <img src="/{{ auth()->user()->photo ? auth()->user()->photo : 'images/user/user.png' }}"
                                            class="img-fluid" alt="" />
                                        <div class="viewer_status">pro</div>
                                    </div>
                                    <div class="caption">
                                        <div class="viewer_header">
                                            <h4>{{ word_view(auth()->user()->name) }}</h4>
                                            <span class="viewer_location">{{ word_view(auth()->user()->city) }}</span>
                                            <ul>
                                                <li><strong>{{ $user_submit_mcq->sum('points') }}</strong> Points</li>
                                                <li><strong>{{ $user_submit_mcq->groupBy('package_id')->count() }}</strong>
                                                    Packages Completed</li>
                                                <li><strong>{{ $user_submit_mcq->groupBy('main_mcq_id')->count() }}</strong>
                                                    MCQ Sets Completed</li>
                                            </ul>
                                        </div>

                                        {{-- <div class="viewer_header">
                                                <ul class="badge_info">
                                                    <li class="started"><i class="ti-rocket"></i></li>
                                                    <li class="medium"><i class="ti-cup"></i></li>
                                                    <li class="platinum"><i class="ti-thumb-up"></i></li>
                                                    <li class="elite unlock"><i class="ti-medall"></i></li>
                                                    <li class="power unlock"><i class="ti-crown"></i></li>
                                                </ul>
                                            </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Row -->



                <!-- Row -->
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <h4>Pending Packages</h4>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="row">
                            @foreach ($enrolls as $package)

                            <!-- Single new Course -->
                            <div class="col-lg-4 col-md-6">
                                <div class="edu-watching">
                                    <div class="property_video sm">
                                        <div class="thumb">
                                            <img class="pro_img img-fluid w100" src="/{{ $package->photo }}"
                                                alt="7.jpg">
                                            <div class="overlay_icon">
                                                <div class="bb-video-box">
                                                    <div class="bb-video-box-inner">
                                                        <div class="bb-video-box-innerup">
                                                            <a href="{{ $package->video }}" data-toggle="modal"
                                                                data-target="#popup-video" class="theme-cl"><i
                                                                    class="ti-control-play"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="edu_duration">10:00</div> --}}
                                    </div>
                                    <div class="edu_video detail">
                                        <div class="edu_video_header">
                                            <h4><a href="{{ route('package.details', ['id' => $package->id, 'title' => $package->slug]) }}">{{ $package->title }}</a></h4>
                                        </div>
                                        <div class="edu_video_bottom">
                                            <div class="edu_video_bottom_left">
                                                @php
                                                $pac = App\Models\Package::find($package->id);
                                                @endphp
                                                <span>Sets
                                                    {{ $pac ? ($pac->mcqs ? $pac->mcqs->count() : '') : ''  }}</span>
                                            </div>
                                            <div class="edu_video_bottom_right">
                                                <i class="ti-desktop"></i>
                                                {{ $pac ? ($pac->class ? $pac->class->name : '') : '' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- /Row -->


            </div>

        </div>
        <!-- Row -->

    </div>
</section>
@endsection

@section('js')
<script src="/js/metisMenu.min.js"></script>
<script>
    $('#side-menu').metisMenu();

</script>
@endsection
