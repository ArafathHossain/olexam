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
                <h2>{{ ($package->class) ? word_view($package->class->name) : '' }} -
                    {{ ($package->subject) ? word_view($package->subject->name) : '' }} - {!! $package->title !!}</h2>
            </div>
            <!-- <div class="col-lg-4 ">
                    <div class="ed_view_link">
                        @if (!$package->enrolls()->where('status', '!=', 'Canceled')->where('user_id',
                        auth()->id())->exists())
                        @if ($package->package_type == 0)
                        <form action="{{ route('free.enroll') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $package->id }}">
                            <button type="submit" class="btn btn-theme enroll-btn">Enroll Now<i
                                    class="ti-angle-right"></i></button>
                        </form>
                        @else
                        <form action="{{ route('add_to_cart') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $package->id }}">
                            <button type="submit" class="btn btn-theme enroll-btn">Add To Cart<i
                                    class="ti-angle-right"></i></button>
                        </form>
                        @endif
                        @endif
                    </div>
            </div> -->
        </div>
        <div class="row align-items-center">

            <div class="col-lg-6 col-md-6">
                <div class="ed_detail_wrap">
                    <ul class="list_ed_detail2">
                        <li class="tag-1"><i class="ti-user"></i><strong>Enrolled:</strong>{{ $package->enrolls_count }}
                            Students</li>
                        <li class="tag-3"><i class="ti-book"></i><strong>Sets:</strong>{{ $package->mcqs_count }} MCQ
                            Sets</li>
                        <li class="tag-4"><i
                                class="ti-tag"></i><strong>Level:</strong>{{ $package->class ? $package->class->name : '' }}
                        </li>
                        <li class="tag-5"><i class="ti-tag"></i><strong>Skill Level:</strong>{{ $package->skill_level }}
                        </li>
                    </ul>
                </div>
                <div class="ed_view_link mt-3">
                    @if (!$package->enrolls()->where('status', '!=', 'Canceled')->where('user_id',
                    auth()->id())->exists())
                    @if ($package->package_type == 0)
                    <form action="{{ route('free.enroll') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $package->id }}">
                        <button type="submit" class="btn btn-theme enroll-btn">Enroll Now<i
                                class="ti-angle-right"></i></button>
                    </form>
                    @else
                    <form action="{{ route('add_to_cart') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $package->id }}">
                        <button type="submit" class="btn btn-theme enroll-btn">Add To Cart<i
                                class="ti-angle-right"></i></button>
                    </form>
                    @endif
                    @endif
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                @php
                $style ='<style>
                    .property_video:before {
                        background: '. ($package->video ? "#17203a" : "transparent").'
                    }
                </style>';
                @endphp
                {!! $style !!}
                <div class="property_video lg">
                    <div class="thumb">
                        <img class="pro_img img-fluid w100" src="{{ asset('' . $package->photo) }}" alt="7.jpg">
                        @if ($package->video != '')
                        <div class="overlay_icon">
                            <div class="bb-video-box">
                                <div class="bb-video-box-inner">
                                    <div class="bb-video-box-innerup">
                                        <a href="{{ $package->video }}" id="package-video-popup" data-toggle="modal"
                                            data-target="#popup-video" class="theme-cl"
                                            data-video="{{ $package->video }}"><i class="ti-control-play"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <form action="{{ route('add.wishlist') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $package->id }}">

                        <button type="submit">
                            <div
                                class="add_to_wishlist {{ (Auth::check() && $package->wishlist_user()->where('user_id', Auth::user()->id)->exists()) ? 'active' : '' }}">
                                Add to Wishlist <i class="fas fa-heart"></i></div>
                        </button>
                    </form>
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

                <!-- Overview -->
                <div class="edu_wraper border">
                    <h4 class="edu_title">Topics Covered</h4>
                    <div id="accordionExample" class="accordion  circullum">

                        <!-- Part 1 -->
                        @php
                        $sl_id = 1;
                        $free_mcq = explode(',', $package->free_mcq)
                        @endphp
                        @foreach ($package->mcqs->groupBy('subject_id') as $k => $mcqs)
                        <div class="card card-name- ">
                            <div id="heading_{{ $k }}" class="card-header bg-white shadow-sm border-0">
                                <h6 class="mb-0 accordion_title">
                                    <a href="#" data-toggle="collapse" data-target="#collapse_{{ $k }}"
                                        aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                        aria-controls="collapse_{{ $k }}"
                                        class="d-block position-relative text-dark collapsible-link py-2">
                                        {{ App\Models\Subject::find($k)->name  ?? "Part 01:"  }}
                                    </a>
                                </h6>
                            </div>
                            <div id="collapse_{{ $k }}" aria-labelledby="heading_{{ $k }}"
                                data-parent="#accordionExample" class="collapse {{ $loop->first ? 'show' : '' }}">
                                <div class="card-body pl-3 pr-3">
                                    <ul class="lectures_lists">
                                        @foreach ($mcqs as $key => $mcq)
                                        @php
                                        $get = App\Models\McqUserAnswer::where('main_mcq_id',
                                        $mcq->id)->where('user_id',
                                        auth()->id())->first();
                                        @endphp
                                        <style>
                                            ul.lectures_lists li.submit_ans:before {
                                                content: "\e64c";
                                            }
                                        </style>
                                        @if ($package->package_type == 1)
                                        @if (auth()->check() && $package->enrolls()->where('status',
                                        'Complete')->where('user_id', auth()->id())->exists())
                                        <a href="{{ route('mcq.exam', ['package_id' => $package->id,'mcq_id' => $mcq->id]) }}"
                                            class="d-flex align-items-center">
                                            <li class="{{ $get ? 'text-success submit_ans' : '' }} d-flex">
                                                <div class="d-flex">
                                                    <div class="lectures_lists_title">
                                                        <i class="ti-control-play"></i>
                                                        Topic: {{ $sl_id++ }}
                                                    </div>
                                                    <span>
                                                        {{ $mcq->title }}
                                                    </span>
                                                </div>
                                                @if ($mcq->optional)
                                                <div class="ml-auto mr-5 mcq_video_icon">
                                                    <button type="button"
                                                        class="btn btn-primary btn-sm rounded mcq_video_btn"
                                                        title="Video" data-toggle="modal" data-target="#mcq_video_modal"
                                                        data-video="{{ $mcq->optional }}"
                                                        onclick="event.preventDefault();">
                                                        <i class="ti-info"></i>
                                                    </button>
                                                </div>
                                                @endif
                                            </li>
                                        </a>
                                        @else
                                        @if (in_array($mcq->id, $free_mcq))
                                        <a href="{{ route('mcq.exam', ['package_id' => $package->id,'mcq_id' => $mcq->id]) }}"
                                            class="d-flex align-items-center">
                                            <li class="{{ $get ? 'text-success ' : '' }}  d-flex">
                                                <div class="d-flex">
                                                    <div class="lectures_lists_title">
                                                        <i class="ti-control-play"></i>
                                                        Topic: {{ $sl_id++ }}
                                                    </div>
                                                    <span>
                                                        {{ $mcq->title }}
                                                    </span>
                                                </div>
                                                @if ($mcq->optional)
                                                <div class="ml-auto mr-5 mcq_video_icon">
                                                    <button type="button"
                                                        class="btn btn-primary btn-sm rounded mcq_video_btn"
                                                        title="Video" data-toggle="modal" data-target="#mcq_video_modal"
                                                        data-video="{{ $mcq->optional }}"
                                                        onclick="event.preventDefault();">
                                                        <i class="ti-info"></i>
                                                    </button>
                                                </div>
                                                @endif
                                            </li>
                                        </a>
                                        @else
                                        <a href="{{ route('mcq.exam', ['package_id' => $package->id,'mcq_id' => $mcq->id]) }}"
                                            class="d-flex align-items-center">
                                            <li class="unview {{ $get ? 'text-success ' : '' }} d-flex">
                                                <div class="d-flex">
                                                    <div class="lectures_lists_title">
                                                        <i class="ti-control-play"></i>
                                                        Topic: {{ $sl_id++ }}
                                                    </div>
                                                    <span>
                                                        {{ $mcq->title }}
                                                    </span>
                                                </div>
                                                @if ($mcq->optional)
                                                <div class="ml-auto mr-5 mcq_video_icon">
                                                    <button type="button"
                                                        class="btn btn-primary btn-sm rounded mcq_video_btn"
                                                        title="Video" data-toggle="modal" data-target="#mcq_video_modal"
                                                        data-video="{{ $mcq->optional }}"
                                                        onclick="event.preventDefault();">
                                                        <i class="ti-info"></i>
                                                    </button>
                                                </div>
                                                @endif
                                            </li>
                                        </a>
                                        @endif
                                        @endif
                                        @else
                                        <a href="{{ route('mcq.exam', ['package_id' => $package->id,'mcq_id' => $mcq->id]) }}"
                                            class="d-flex align-items-center">
                                            <li class="{{ $get ? 'text-success submit_ans' : '' }} d-flex">
                                                <div class="d-flex">
                                                    <div class="lectures_lists_title">
                                                        <i class="ti-control-play"></i>
                                                        Topic: {{ $sl_id++ }}
                                                    </div>
                                                    <span>
                                                        {{ $mcq->title }}
                                                    </span>
                                                </div>
                                                @if ($mcq->optional)
                                                <div class="ml-auto mr-5 mcq_video_icon">
                                                    <button type="button"
                                                        class="btn btn-primary btn-sm rounded mcq_video_btn"
                                                        title="Video" data-toggle="modal" data-target="#mcq_video_modal"
                                                        data-video="{{ $mcq->optional }}"
                                                        onclick="event.preventDefault();">
                                                        <i class="ti-info"></i>
                                                    </button>
                                                </div>
                                                @endif
                                            </li>
                                        </a>
                                        @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="edu_wraper border">
                    <h4>Description</h4>
                    {!! $package->description !!}
                </div>

                <!-- Reviews -->
                <!-- <div class="rating-overview border">
                    <div class="rating-overview-box">
                        <span class="rating-overview-box-total">{{$package->reviews_count > 0 ?
                            round($package->reviews->sum('rating') /
                            $package->reviews_count, 2) : 0}}</span>
                        <span class="rating-overview-box-percent">out of 5.0</span>
                        <div class="star-rating" data-rating="5"><i class="ti-star"></i><i class="ti-star"></i><i
                                class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i>
                        </div>
                    </div>
                    @if ($package->reviews_count > 0)

                    <div class="rating-bars">
                        @php
                        $star1 = $package->reviews->where('rating', 1)->count();
                        $star2 = $package->reviews->where('rating', 2)->count();
                        $star3 = $package->reviews->where('rating', 3)->count();
                        $star4 = $package->reviews->where('rating', 4)->count();
                        $star5 = $package->reviews->where('rating', 5)->count();
                        $class = [5 => 'high', 4 => 'good', 3 => 'mid', 2 => 'poor', 1 => 'poor'];
                        for ($i=5;$i>=1;--$i) {
                        $var = "star$i";
                        $count = $$var;
                        $percent = round($count * 100 / $package->reviews_count);
                        echo '
                        <div class="rating-bars-item">
                            <span class="rating-bars-name">'.$i.' Star</span>
                            <span class="rating-bars-inner">
                                <span class="rating-bars-rating '.$class[$i].'" data-rating="2.0">
                                    <span class="rating-bars-rating-inner" style="width:'.$percent.'%"></span>
                                </span>
                                <strong>'.$percent.'%</strong>
                            </span>
                        </div>
                        ';
                        }
                        @endphp
                    </div>
                    @endif
                </div> -->

                {{-- structor  --}}
                <div class="single_instructor border">
                    <div class="single_instructor_thumb">
                        <a href="#"><img src="{{ asset('images/user-3.jpg') }}" class="img-fluid" alt=""></a>
                    </div>
                    <div class="single_instructor_caption">
                        <h4><a href="#">Jonathan Campbell</a></h4>
                        <!-- <ul class="instructor_info">
                            <li><i class="ti-video-camera"></i>72 Videos</li>
                            <li><i class="ti-control-forward"></i>102 Lectures</li>
                            <li><i class="ti-user"></i>Exp. 4 Year</li>
                        </ul> -->
                        <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium
                            voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi.</p>
                        <!-- <ul class="social_info">
                            <li><a href="#"><i class="ti-facebook"></i></a></li>
                            <li><a href="#"><i class="ti-twitter"></i></a></li>
                            <li><a href="#"><i class="ti-linkedin"></i></a></li>
                            <li><a href="#"><i class="ti-instagram"></i></a></li>
                        </ul> -->
                    </div>
                </div>

                <!-- Submit Reviews -->
                <div class="edu_wraper">
                    <h4 class="edu_title">Reviews</h4>
                    <div class="review-form-box form-submit">
                        <form method="POST" action="{{ route('create.review') }}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <!-- Review Box -->
                                    <!-- <div class="review-form-box-star">
                                        <input type="hidden" name="package_id" value="{{ $package->id }}">
                                        <div class="form-group">
                                            <label class="mr-3">Your rating:</label>
                                            <ul class="d-inline-flex">
                                                <li title='Poor' data-value="1"><i class="fas fa-star"></i></li>
                                                <li title='Fair' data-value="2"><i class="fas fa-star"></i></li>
                                                <li title='Good' data-value="3"><i class="fas fa-star"></i></li>
                                                <li title='Excellent' data-value="4"><i class="fas fa-star"></i>
                                                </li>
                                                <li title='WOW!!!' data-value="5"><i class="fas fa-star"></i>
                                                </li>
                                            </ul>
                                            <input type="hidden" name="rating" id="package_star">
                                            @if ($errors->has('rating'))
                                            <div class="text-danger">
                                                {{ $errors->first('rating') }}
                                            </div>
                                            @endif
                                        </div>
                                    </div> -->
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <!-- <label>Review</label> -->
                                        <textarea class="form-control importantClass"
                                            placeholder="Write your review here . . ." name="comment"></textarea>
                                        @if ($errors->has('comment'))
                                        <div class="text-danger">
                                            {{ $errors->first('comment') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="col-lg-12 col-md-12 col-sm-12 ">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-theme float-right">Submit</button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>

                {{-- views  --}}
                <div class="list-single-main-item fl-wrap">
                    <!-- <div class="list-single-main-item-title fl-wrap">
                        <h3>Item Reviews - <span> {{ $package->reviews_count }} </span></h3>
                    </div> -->
                    <div class="reviews-comments-wrap">
                        @foreach ($package->reviews as $review)
                        <div class="reviews-comments-item">
                            <div class="review-comments-avatar">
                                <img src="{{ asset('' . $review->user ? $review->user->photo : 'images/user/user.png') }}"
                                    class="img-fluid" alt="">
                            </div>
                            <h4>
                                <span>{{ $review->user ? $review->user->name : 'unknown' }}</span>
                                <span class="reviews-comments-item-date">
                                    <i class="ti-calendar theme-cl"></i>
                                    {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $review->created_at)->format('d-m-Y') }}
                                </span>
                            </h4>

                            <!-- <div class="listing-rating high" data-starrating2="5">
                                @php
                                for ($i=0; $i < $review->rating; $i++) {
                                    echo '<i class="ti-star active"></i>';
                                    }
                                    @endphp
                                    <span class="review-count">({{ $review->rating }})</span> </div>
                            <div class="clearfix"></div> -->
                            <p>" {!! $review->comment !!} "</p>
                        </div>
                        @endforeach
                    </div>
                </div>



            </div>

            <!-- Sidebar -->
            <div class="col-lg-4 col-md-4">

                <div class="ed_view_box style_2 border">

                    <!-- <div class="ed_author">
                        <div class="ed_author_thumb">
                            <img class="img-fluid"
                                src="/{{ $package->user->photo ? $package->user->photo : 'images/user/user.png' }}"
                                alt="7.jpg">
                        </div>
                        <div class="ed_author_box">
                            <h4>{{ $package->user ? $package->user->name : '' }}</h4>
                        </div>
                    </div> -->

                    <div class="ed_view_price pl-4 mt-3">
                        <span>Acctual Price</span>
                        @if ($package->package_type == 1)
                        <h2 class="theme-cl">{!! $package->org_price ? '<del> '.currency_type($package->org_price)
                                .'</del>' : '' !!} <div class="d-inline-block">{{ currency_type($package->sale_price) }}
                            </div>
                        </h2>
                        @else
                        <h2 class="theme-cl">
                            <div class="d-inline-block">Free</div>
                        </h2>
                        @endif
                    </div>
                    <div class="ed_view_features pl-4">
                        <span>Course Features</span>
                        <ul>
                            @if ($package->features != '')
                            @php
                            $features = explode('||', $package->features);
                            @endphp
                            @foreach ($features as $fea)
                            <li><i class="ti-angle-right"></i>{{ $fea }}</li>
                            @endforeach
                            @endif
                        </ul>
                    </div>
                    <!-- <div class="ed_view_link">
                        @if (!$package->enrolls()->where('status', '!=', 'Canceled')->where('user_id',
                        auth()->id())->exists())
                        @if ($package->package_type == 0)
                        <form action="{{ route('free.enroll') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $package->id }}">
                            <button type="submit" class="btn btn-theme enroll-btn">Enroll Now<i
                                    class="ti-angle-right"></i></button>
                        </form>
                        @else
                        <form action="{{ route('add_to_cart') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $package->id }}">
                            <button type="submit" class="btn btn-theme enroll-btn">Add To Cart<i
                                    class="ti-angle-right"></i></button>
                        </form>
                        @endif
                        @endif
                    </div> -->

                </div>

                <!-- <div class="edu_wraper border">
                    <h4 class="edu_title">Course Features</h4>
                    <ul class="edu_list right">
                        <li><i class="ti-user"></i>Student Enrolled:<strong>{{ $package->enrolls_count }}</strong></li>
                        <li><i class="ti-files"></i>Sets:<strong>{{ $package->mcqs_count }} MCQ Sets</strong></li>
                        <li><i class="ti-tag"></i>Skill Level:<strong>{{ $package->skill_level }}</strong></li>
                        <li><i class="ti-flag-alt"></i>Language:<strong>{{ $package->mediam }}</strong></li>
                    </ul>
                </div> -->
                <!-- Submit Reviews
                <div class="edu_wraper border">
                    <h4 class="edu_title">Submit Reviews</h4>
                    <div class="review-form-box form-submit">
                        <form method="POST" action="{{ route('create.review') }}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="review-form-box-star">
                                        <input type="hidden" name="package_id" value="{{ $package->id }}">
                                        <div class="form-group">
                                            <label class="mr-3">Your rating:</label>
                                            <ul class="d-inline-flex">
                                                <li title='Poor' data-value="1"><i class="fas fa-star"></i></li>
                                                <li title='Fair' data-value="2"><i class="fas fa-star"></i></li>
                                                <li title='Good' data-value="3"><i class="fas fa-star"></i></li>
                                                <li title='Excellent' data-value="4"><i class="fas fa-star"></i>
                                                </li>
                                                <li title='WOW!!!' data-value="5"><i class="fas fa-star"></i>
                                                </li>
                                            </ul>
                                            <input type="hidden" name="rating" id="package_star">
                                            @if ($errors->has('rating'))
                                            <div class="text-danger">
                                                {{ $errors->first('rating') }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label>Review</label>
                                        <textarea class="form-control ht-140" placeholder="Review"
                                            name="comment"></textarea>
                                        @if ($errors->has('comment'))
                                        <div class="text-danger">
                                            {{ $errors->first('comment') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-theme">Submit Review</button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div> -->
            </div>

        </div>
    </div>
</section>
<!-- ============================ Package Detail ================================== -->

<!-- Video Modal -->
<div class="modal fade" id="popup-video" tabindex="-1" role="dialog" aria-labelledby="popup-video" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <iframe class="embed-responsive-item" width="100%" height="480" src="" frameborder="0"
            allow="autoplay; encrypted-media" allowfullscreen></iframe>
    </div>
</div>
<!-- End Video Modal -->
<!-- Video Modal -->
<div class="modal fade" id="mcq_video_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <iframe class="embed-responsive-item" width="100%" height="480" src="" frameborder="0"
                allow="autoplay; encrypted-media" allowfullscreen></iframe>

        </div>
    </div>
</div>
<!-- End Video Modal -->
<!-- ============================ Full Width Courses End ================================== -->
@endsection
@section('custom_js')
<script>
    $('.mcq_video_btn').each(function () {
        $(this).on('click', function () {
            var video_ = $(this).data('video');
            $('#mcq_video_modal').find('.embed-responsive-item')[0].src = video_;
        })
    });
    
    $('#package-video-popup').on('click', function () {
        var video_ = $(this).data('video');
        $('#popup-video').find('.embed-responsive-item')[0].src = video_;
    });
    
    $('.review-form-box-star ul li').on('mouseover', function () {
        var onStar = parseInt($(this).data('value'), 10);
        $(this).parent().children('li').each(function (e) {
            if (e < onStar) {
                $(this).addClass('hover');
            } else {
                $(this).removeClass('hover');
            }
        });
    }).on('mouseout', function () {
        $(this).parent().children('li').each(function (e) {
            $(this).removeClass('hover');
        });
    });

    var ratingValue = 0;
    /* 2. Action to perform on click */
    $('.review-form-box-star ul li').on('click', function () {
        var onStar = parseInt($(this).data('value'), 10);
        var stars = $(this).parent().children('li');
        for (var i = 0; i < stars.length; i++) {
            $(stars[i]).removeClass('selected');
        }
        for (var i = 0; i < onStar; i++) {
            $(stars[i]).addClass('selected');
        }
        var ratingValue = parseInt($('.review-form-box-star ul li.selected').last().data('value'), 10);
        $('#package_star').val(ratingValue ? ratingValue : 0);
    });

</script>
@endsection