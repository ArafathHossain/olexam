@extends('layouts.frontend')
@section('content')

<!-- ============================ Banner  Start================================== -->
<div class="image-cover hero_banner hero-inner-2 shadow rlt"
    style="background:url(/{{ home_page('banner_photo', 'images/banner-2.jpg') }}) no-repeat;" data-overlay="7">

    <div class="container">

        <div class="hero-caption small_wd mb-5">
            <h1 class="big-header-capt cl_2 mb-0">{!! home_page('title', 'Online Live MCQ Exams At Your Fingertips') !!}</h1>
            <p>{!!  home_page('content','Attend Live Exams Online. Explore thousands of Live MCQ Exam Packages!!')  !!}</p>
        </div>
        <!-- Type -->
        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12">
                <div class="banner-search shadow_high">
                    <div class="search_hero_wrapping">
                        <form action="{{ route('package') }}" method="GET" id="search_hero_form">
                            <div class="row">
                                <div class="col-lg-5 col-md-5 col-sm-12 br-right">
                                    <div class="form-group">
                                        <div class="input-with-icon">
                                            <input type="text" class="form-control term" placeholder="Keyword"
                                                name="term_" />
                                            <img src="{{ asset('images/search.svg')}}" class="search-icon" alt="" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-5 col-md-4 col-sm-12 small-pad">
                                    <div class="form-group">
                                        <div class="input-with-icon">
                                            @php
                                            $classes = App\Models\StudentClass::all();
                                            @endphp
                                            <select id="c-category" class="form-control class" name="cls_">
                                                <option value="">&nbsp;</option>
                                                @foreach ($classes as $class)
                                                <option value="{{ $class->id }}">{{ word_view($class->name) }}</option>
                                                @endforeach
                                            </select>
                                            <img src="{{ asset('images/pin.svg')}}" class="search-icon" alt="" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-3 col-sm-12 pl-0">
                                    <div class="form-group none">
                                        <button type="submit" id="search_hero_btn"
                                            class="btn search-btn full-width">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ============================ Banner End ================================== -->

<!-- ========================= Featured Classes Part Starts ======================== -->
<!-- <section class="bg-light">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-lg-12 col-md-12 mb-3">
                <div class="sec-heading2">
                    <div class="sec-left">
                        <h3>Popular Packages</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 p-0">

                <div class="arrow_slide three_slide-dots arrow_middle">

                    
                    @foreach ($popular_packages as $package)
{{--                    <div class="singles_items">--}}
{{--                        <div class="edu_cat">--}}
{{--                            <div class="pic">--}}
{{--                                <a class="pic-main" href="{{ route('package.details', [$package->id, $package->slug]) }}" style="background-image:url(/{{ $package->photo }});"></a>--}}
{{--                            </div>--}}
{{--                            <div class="edu_data">--}}
{{--                                <h4 class="title"><a--}}
{{--                                        href="{{ route('package.details', [$package->id, $package->slug]) }}">{{ $package->class ? word_view($package->class->name) : '' }}</a></h4>--}}
{{--                                <ul class="meta">--}}
{{--                                    <li class="lessions"><i class="ti-book"></i>{{ $package->mcqs_count }} Mcqs</li>--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                        <div class="singles_items">
                            <div class="education_block_grid style_2">
                                <div class="education_block_thumb n-shadow">
                                    <a href="{{ route('package.details', [$package->id, $package->slug]) }}"><img
                                            src="/{{ $package->photo }}" class="img-fluid" alt=""></a>
                                    <div class="cources_price">{!! ($package->package_type == 1) ?
                                    '<span><del>'.currency_type($package->org_price).'</del></span>
                                    <span>'.currency_type($package->sale_price).'</span>' : 'Free' !!}</div>
                                    <form action="{{ route('add.wishlist') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $package->id }}">
                                        <button type="submit"
                                                class="add_to_wishlist {{ (Auth::check() && $package->wishlist_user()->where('user_id', auth()->id())->exists()) ? 'active' : '' }}"><i
                                                class="fas fa-heart"></i></button>
                                    </form>
                                </div>

                                <div class="education_block_body">
                                    <h4 class="bl-title"><a
                                            href="{{ route('package.details', [$package->id, $package->slug]) }}">{!!
                                        word_view($package->title) !!}</a></h4>
                                </div>

                                <div class="cources_info_style3">
                                    <ul class="d-flex justify-content-between">
                                        <li><i class="ti-eye mr-2"></i>{{ $package->view }} Views</li>
                                        @php
                                            $reviews = $package->reviews->count() > 0 ?
                                            round($package->reviews->sum('rating') /
                                            $package->reviews->count(), 2) : 0
                                        @endphp
                                        <li><i class="ti-star text-warning mr-2"></i>{{ $reviews }} Reviews</li>
                                    </ul>
                                </div>

                                <div class="education_block_footer">
                                    <div class="education_block_author">
                                        <div class="path-img"><img src="{{ $package->user->photo ?? asset('images/user-1.jpg')}}" class="img-fluid"
                                                                   alt="">
                                        </div>
                                        <h5>{{ $package->user->name ?? 'Unknown' }}</h5>
                                    </div>
                                    <div class="foot_lecture"><i
                                            class="ti-control-skip-forward mr-2"></i>{{ $package->user ? $package->user->packages->count() : 0 }}
                                        lectures</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

    </div>
</section> -->
<!-- ========================= Featured Classes Part Starts ======================== -->

<!-- ============================ Featured Packages Start ================================== -->
<section>
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-lg-12 col-md-12 mb-3">
                <div class="sec-heading2">
                    <div class="sec-left">
                        <h3>Featured Packages</h3>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 p-0">

                <div class="arrow_slide three_slide arrow_middle">

                    <!-- Single Slide -->
                    @foreach ($featured_packages as $package)
                    <div class="singles_items">
                        <div class="education_block_grid style_2">
                            <div class="education_block_thumb n-shadow">
                                <a href="{{ route('package.details', [$package->id, $package->slug]) }}"><img
                                        src="/{{ $package->photo }}" class="img-fluid" alt=""></a>
                                <div class="cources_price">{!! ($package->package_type == 1) ?
                                    '<span><del>'.currency_type($package->org_price).'</del></span>
                                    <span>'.currency_type($package->sale_price).'</span>' : 'Free' !!}</div>
                                <form action="{{ route('add.wishlist') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $package->id }}">
                                    <button type="submit"
                                        class="add_to_wishlist {{ (Auth::check() && $package->wishlist_user()->where('user_id', auth()->id())->exists()) ? 'active' : '' }}"><i
                                            class="fas fa-heart"></i></button>
                                </form>
                            </div>

                            <div class="education_block_body">
                                <h4 class="bl-title"><a
                                        href="{{ route('package.details', [$package->id, $package->slug]) }}">{!!
                                        word_view($package->title) !!}</a></h4>
                            </div>

                            <div class="cources_info_style3">
                                <ul class="d-flex justify-content-between">
                                    <li><i class="ti-eye mr-2"></i>{{ $package->view }} Views</li>
                                    @php
                                    $reviews = $package->reviews->count() > 0 ?
                                    round($package->reviews->sum('rating') /
                                    $package->reviews->count(), 2) : 0
                                    @endphp
                                    <li><i class="ti-star text-warning mr-2"></i>{{ $reviews }} Reviews</li>
                                </ul>
                            </div>

                            <div class="education_block_footer">
                                <div class="education_block_author">
                                    <div class="path-img"><img src="{{ $package->user->photo ?? asset('images/user-1.jpg')}}" class="img-fluid"
                                            alt="">
                                    </div>
                                    <h5>{{ $package->user->name ?? 'Unknown' }}</h5>
                                </div>
                                <div class="foot_lecture"><i
                                        class="ti-control-skip-forward mr-2"></i>{{ $package->user ? $package->user->packages->count() : 0 }}
                                    lectures</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>

    </div>
</section>
<!-- ============================ Featured Courcses End ================================== -->

<!-- ========================== Featured Category Section =============================== -->
<section class="bg-light">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-6 col-sm-12">
                <div class="sec-heading center">
                    <p>Popular Category</p>
                    <h2><span class="theme-cl">Exclusive Package</span> Categories for Online MCQ Exams</h2>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach ($subjects as $subject)
            <div class="col-lg-4 col-md-4 col-sm-6">
                <a class="pic-main" href="{{ route('package') . '?cls_=' . $class_id . '&sub_='.$subject->id }}">
                    <div class="edu_cat_2 " style="background: rgba({{ $subject->color }},.2)">
                        <div class="edu_cat_icons">
                            <img src="{{ asset($subject->photo)}}" class="img-fluid" alt="" />
                        </div>
                        <div class="edu_cat_data">
                            <h4 class="title">{!! $subject->name !!}</h4>
                            <ul class="meta">
                                <li class="video"><i class="ti-video-clapper"></i>{{ $subject->packages_count }}
                                    Packages</li>
                            </ul>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        
    </div>
</section>
<!-- ========================== Featured Category Section =============================== -->


@endsection
