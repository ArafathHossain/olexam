@extends('layouts.frontend')
@section('css')
<link href="{{ asset('css/noui.css')}}" rel="stylesheet">
@endsection
@section('content')
<!-- ============================ Page Title Start================================== -->
<section class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">

                <div class="breadcrumbs-wrap">
                    <h1 class="breadcrumb-title">Access All Packages</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">All
                                Packages</li>
                        </ol>
                    </nav>
                </div>

            </div>
        </div>
    </div>
</section>
<!-- ============================ Page Title End ================================== -->


<!-- ============================ Find Courses with Sidebar ================================== -->
<section class="pt-0">
    <div class="container">

        <!-- Row -->
        <div class="row">
            <div class="col-lg-4 col-md-12 col-sm-12 order-2 order-lg-1 order-md-2">
                <div class="page_sidebar hide-23">

                    <!-- =========================================================
                        Price Filter Starts 
                    ==============================================================-->
                    <!-- partial:index.partial.html -->

                    <style>
                        input[type=range]::-webkit-slider-thumb {
                            pointer-events: all;
                            width: 24px;
                            height: 24px;
                            -webkit-appearance: none;

                            /* @apply w-6 h-6 appearance-none pointer-events-auto; */
                        }

                    </style>
                    @php
                    $class_id = Request::get('cls_');
                    if ($class_id) {
                    $subjects = App\Models\StudentClass::find($class_id)->subjects;
                    } else {
                    $subjects = App\Models\StudentClass::all()->random()->subjects;
                    }
                    @endphp

                    <h4 class="side_title mb-4">Price Filter</h4>
                    <div class=" ">
                        {{-- <div x-data="range()" x-init="mintrigger(); maxtrigger()" class="relative max-w-xl w-full">
                            <div>
                                <input type="range" step="1" id="price_handle_min" x-bind:min="min" x-bind:max="max"
                                    x-on:input="mintrigger" x-model="minprice"
                                    class="absolute pointer-events-none appearance-none z-20 h-2 w-full opacity-0 cursor-pointer">

                                <input type="range" step="1" id="price_handle_max" x-bind:min="min" x-bind:max="max"
                                    x-on:input="maxtrigger" x-model="maxprice"
                                    class="absolute pointer-events-none appearance-none z-20 h-2 w-full opacity-0 cursor-pointer">

                                <div class="relative z-10 h-2">

                                    <div class="absolute z-10 left-0 right-0 bottom-0 top-0 rounded-md bg-gray-200">
                                    </div>

                                    <div class="absolute z-20 top-0 bottom-0 rounded-md bg-green-300"
                                        x-bind:style="'right:'+maxthumb+'%; left:'+minthumb+'%'"></div>

                                    <div class="absolute z-30 w-6 h-6 top-0 left-0 bg-green-300 rounded-full -mt-2"
                                        x-bind:style="'left: '+minthumb+'%'"></div>

                                    <div class="absolute z-30 w-6 h-6 top-0 right-0 bg-green-300 rounded-full -mt-2"
                                        x-bind:style="'right: '+maxthumb+'%'"></div>

                                </div>

                            </div>

                            <div class=" d-flex flex justify-between items-center py-4">
                                <div>
                                    <input type="text" maxlength="5" x-on:input="mintrigger" x-model="minprice"
                                        class="px-3 py-2 border border-gray-200 rounded w-24 text-center">
                                </div>
                                <div>
                                    <input type="text" maxlength="5" x-on:input="maxtrigger" x-model="maxprice"
                                        class="px-3 py-2 border border-gray-200 rounded w-24 text-center">
                                </div>
                            </div>

                        </div> --}}
                        <div id="slider-range"></div>


                        <div class=" d-flex justify-content-between align-items-center red-skin my-3">

                            <form method="GET" id="price_range_form ">
                                <div class=" d-flex justify-content-between">
                                    <input type="text" class="form-control" style="height:45px" name="min_"
                                        value="{{ Request::get('min_') }}" id="range-price-min">
                                    <input type="text" class="form-control ml-3" style="height:45px" name="max_"
                                        value="{{ Request::get('max_') }}" id="range-price-max">
                                </div>
                            </form>



                            <button type="button" class="btn btn-theme" id="price_range_btn">Filter</button>
                        </div>
                    </div>

                    <!-- =========================================================
                        Price Filter Ends 
                    ==============================================================-->

                    <h4 class="side_title">Packages</h4>
                    <form action="{{ Request::fullUrl() }}" id="price_sort_form" method="GET">
                        <ul class="no-ul-list mb-3 price_sort">
                            <li>
                                <input id="aa-10" class="checkbox-custom" name="sort_" type="radio" value="all"
                                    {{ Request::get('sort_') == 'all' ? 'checked' : '' }}>
                                <label for="aa-10" class="checkbox-custom-label">All
                                    ({{ $total_package = DB::table('packages')->where('class_id', $class_id)->count() }})</label>
                            </li>
                            <li>
                                <input id="b-8" class="checkbox-custom" name="sort_" type="radio" value="free"
                                    {{ Request::get('sort_') == 'free' ? 'checked' : '' }}>
                                <label for="b-8" class="checkbox-custom-label">Free Packages
                                    ({{ DB::table('packages')->where('class_id', $class_id)->where('package_type', 0)->count() }})</label>
                            </li>
                            <li>
                                <input id="b-9" class="checkbox-custom" name="sort_" type="radio" value="premium"
                                    {{ Request::get('sort_') == 'premium' ? 'checked' : '' }}>
                                <label for="b-9" class="checkbox-custom-label">Premium Packages
                                    ({{ DB::table('packages')->where('class_id', $class_id)->where('package_type', 1)->count() }})</label>
                            </li>
                        </ul>
                    </form>

                    <!-- =========================================================
                        Subject Filter Starts 
                    ==============================================================-->


                    <!-- Search Form -->
                    <form class="form-inline addons mb-3" method="GET" id="package_search_form">
                        <input class="form-control" id="package_search_input" type="search" placeholder="Search Subject" aria-label="Search">
                        <button id="package_search_btn" class="btn my-2 my-sm-0" type="submit"><i class="ti-search"></i></button>
                    </form>

                    <h4 class="side_title">Subjects</h4>
                    <ul class="no-ul-list mb-3" id="subject_filter">
                        <form action="#" method="GET" id="subject_filter_form">
                            @if (Request::get('sub_'))
                            @php
                            $subs = explode(',', Request::get('sub_'));
                            @endphp
                            @else
                            @php
                            $subs = [];
                            @endphp
                            @endif

                            @foreach ($subjects as $key => $subject)
                            <li>
                                <input id="aa-{{ $key }}" class="checkbox-custom" name="sub_[]" type="checkbox"
                                    value="{{ $subject->id }}" {{ in_array( $subject->id, $subs) ? 'checked' : '' }}>
                                <label for="aa-{{ $key }}" class="checkbox-custom-label">{{ $subject->name }}
                                    ({{ $subject->packages->where('class_id', $class_id)->count() }})</label>
                            </li>
                            @endforeach
                        </form>
                    </ul>
                    <!-- =========================================================
                        Subject Filter Ends 
                    ==============================================================-->


                </div>

                <div class="page_sidebar hidden-md-down">
                    <h4 class="side_title">Related Packages</h4>
                    <div class="related_items mb-4">
                        @php
                        $recent = DB::table('packages')
                        ->orderBy('id', 'desc')
                        ->take(4)
                        ->get()

                        @endphp
                        <!-- Single Related Items -->
                        @foreach ($recent as $item)
                        <div class="product_item">
                            <div class="thumbnail">
                                <a href="{{ route('package.details', [$item->id, $item->slug]) }}"><img
                                        src="{{ asset(''. $item->photo)}}" class="img-fluid" alt=""></a>
                            </div>
                            <div class="info">
                                <h6 class="product-title">
                                    <a href="{{ route('package.details', [$item->id, $item->slug]) }}">{!! $item->title
                                        !!}</a>
                                </h6>
                                <div class="woo_rating">
                                    @php
                                    $reviews = DB::table('reviews')->where('package_id','=', $item->id);
                                    $rate = $reviews->count() > 0 ?
                                    round($reviews->sum('rating') /
                                    $reviews->count(), 2) : 0
                                    @endphp
                                    <?php
                            for ($i=0; $i <5 ; $i++) {
                                echo '<i class="' ,( $rate <= $i?' fas fa-star ':'fas fa-star filled'),'"></i>';
                            }
                             ?>
                                </div>
                                @if ($item->package_type == 1)
                                <span class="price">
                                    <p class="price_ver">
                                        {{ currency_type($item->sale_price) }}<del>{{ currency_type($item->org_price) }}</del>
                                    </p>
                                </span>
                                @else
                                <span class="price">
                                    <p class="price_ver">Free</p>
                                </span>
                                @endif

                            </div>
                        </div>
                        @endforeach

                    </div>

                </div>

            </div>

            <div class="col-lg-8 col-md-12 col-sm-12 order-1 order-lg-2 order-md-1">

                <!-- Row -->
                <div class="row align-items-center mb-3">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        We found <strong>{{ $total_package }}</strong> Packages for you
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 ordering">
                        <div class="filter_wraps justify-content-between">
                            <div class="form-group mb-0 w-50 pl-2">
                                <select id="courses_type" class="form-control">
                                    <option value="1">Popular</option>
                                    <option value="2">Recent</option>
                                    <option value="3">Featured</option>
                                </select>
                            </div>
                            <div class="form-group mb-0 w-50 pl-2">
                                <select id="class_type" class="form-control">
                                    @foreach ($classes as $key => $class)
                                    <option value="{{ $class->id }}"
                                        {{ Request::get('cls_') == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Row -->

                <div class="row" id="all_packages">
                    <!-- Cource Grid 1 -->
                    @forelse ($packages as $package)
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="education_block_grid style_2">

                            <div class="education_block_thumb n-shadow">
                                <a
                                    href="{{ route('package.details', ['id' => $package->id, 'title' => $package->slug]) }}"><img
                                        src="{{ asset(''.$package->photo)}}" class="img-fluid" alt=""></a>
                                <div class="cources_price">{!! ($package->package_type == 1) ?
                                    '<span><del>'.currency_type($package->org_price).'</del></span>
                                    <span>'.currency_type($package->sale_price).'</span>' : 'Free' !!}</div>
                            </div>

                            <div class="education_block_body">
                                <h4 class="bl-title"><a
                                        href="{{ route('package.details', [$package->id, $package->slug]) }}">{!!
                                        $package->title !!}</a></h4>
                            </div>

                            <div class="cources_info_style3">
                                <ul>
                                    <li><i class="ti-eye mr-2"></i>{{ $package->view }} Views</li>
                                    <!-- <li><i class="ti-time mr-2"></i>6h 40min</li> -->

                                    <li><i class="ti-star text-warning mr-2"></i>{{ $package->reviews->count() }}
                                        Reviews</li>
                                </ul>
                            </div>

                            <div class="education_block_footer">
                                <div class="education_block_author">
                                    <div class="path-img"><a href="#"><img
                                                src="{{ asset($package->user->photo ?? "images/user-1.jpg")}}" class="img-fluid" alt=""></a>
                                    </div>
                                    <h5><a href="#">{{ $package->user ? $package->user->name : '' }}</a></h5>
                                </div>
                                <div class="foot_lecture"><i class="ti-control-skip-forward mr-2"></i>{{ $package->mcqs_count }} MCQ Sets</div>
                            </div>

                        </div>
                    </div>
                    @empty
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <span>No Package Found !</span>
                    </div>
                    @endforelse

                </div>
                @php
                $packages->appends(Request::all())->links();
                @endphp
                <!-- Row -->
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <!-- Pagination -->
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                                <button type="button" class="btn btn-loader" data-page="2"
                                    data-link="{{Request::fullUrl()}}{{ (strstr(Request::fullUrl(), '?')) ? "&" : "?" }}page="
                                    data-div="#all_packages" data-last="{{ $packages->lastPage() }}">Load More<i
                                        class="fas fa-sync-alt ml-3 "></i></button>
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
<!-- ============================ Find Courses with Sidebar End ================================== -->
@endsection
@section('js')
{{-- <script src="{{ asset('js/range.js')}}"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/10.1.0/nouislider.min.js"></script>
@endsection
@section('custom_js')
<script>
    /*
    Load more ajax
    */
    if ($(".btn-loader").data('last') < $(".btn-loader").data('page')) {
        $(".btn-loader").hide();
    }
    $(".btn-loader").click(function () {
        var _This = $(this);
        _This.find('.fas').addClass('fa-spin');
        $div = $($(this).data('div'));
        $link = $(this).data('link');
        $last = parseInt($(this).data('last'));

        $page = $(this).data('page');
        $href = $link + $page;
        $.get($href, function (response) {
            $html = $(response).find("#all_packages").html();
            $div.append($html);
            _This.find('.fas').removeClass('fa-spin');
        });
        if ($last <= $page) {
            _This.hide();
        }
        $(this).data('page', (parseInt($page) + 1));
    });

    // sort by price
    $('#price_sort_form ul li input').on('change', function () {
        event.preventDefault();
        let formData = $('#price_sort_form').serialize(),
            urlParams = new URLSearchParams(window.location.search),
            cls = urlParams.get('cls_'),
            sub = urlParams.get('sub_'),
            q = $('#package_search_input').val(),
            min_ = urlParams.get('min_'),
            max_ = urlParams.get('max_');
        if (cls != null) {
            window.location.href = 'package?cls_=' + cls + '&' + formData;
        }
        if (cls != null && q != '') {
            window.location.href = 'package?cls_=' + cls + '&' + formData + '&q_=' + q;
        }
        if (sub != null && cls != null) {
            window.location.href = 'package?cls_=' + cls + '&sub_=' + sub + '&' + formData;
        }
        if (sub != null && cls != null && q != '') {
            window.location.href = 'package?cls_=' + cls + '&sub_=' + sub + '&' + formData + '&q_=' + q;
        }
        if (min_ != null && max_ != null && sub != null && cls != null) {
            window.location.href = 'package?cls_=' + cls + '&min_=' + min_ + '&max_=' + max_ + '&sub_=' + sub +
                '&' + formData;
        }
        if (min_ != null && max_ != null && sub != null && cls != null && q != '') {
            window.location.href = 'package?cls_=' + cls + '&min_=' + min_ + '&max_=' + max_ + '&sub_=' + sub +
                '&' + formData + '&q_=' + q;
        }
    });
    // search form 
    $('#package_search_btn').on('click', function () {
        event.preventDefault();
        let q = $('#package_search_input').val(),
            urlParams = new URLSearchParams(window.location.search),
            cls = urlParams.get('cls_');
        if (cls != null && q != '') {
            window.location.href = 'package?cls_=' + cls + '&q_=' + q;
        }
        // if (sub != null && cls != null) {
        //     window.location.href = 'package?cls_=' + cls + '&sub_=' + sub + '&' + formData;
        // }
        // if (min_ != null && max_ != null && sub != null && cls != null) {
        //     window.location.href = 'package?cls_=' + cls + '&min_=' + min_ + '&max_=' + max_ + '&sub_=' + sub +
        //         '&' + formData;
        // }
    });
    $('#subject_filter li input').on('change', function () {
        event.preventDefault();
        let formData = $('#subject_filter_form').serializeArray();
        let sub = [];
        $.each(formData, function (i, obj) {
            sub.push(obj.value)
        })
        let subs = sub.toString();
        urlParams = new URLSearchParams(window.location.search),
            cls = urlParams.get('cls_'),
            sort = urlParams.get('sort_'),
            q = $('#package_search_input').val(),
            min_ = urlParams.get('min_'),
            max_ = urlParams.get('max_');
        if (cls != null) {
            window.location.href = 'package?cls_=' + cls + '&sub_=' + subs;
        }
        if (cls != null && q != '') {
            window.location.href = 'package?cls_=' + cls + '&sub_=' + subs + '&q_=' + q;
        }
        if (sort != null && cls != null) {
            window.location.href = 'package?cls_=' + cls + '&sort_=' + sort + '&sub_=' + subs;
        }
        if (sort != null && cls != null && q != '') {
            window.location.href = 'package?cls_=' + cls + '&sort_=' + sort + '&sub_=' + subs + '&q_=' + q;
        }
        if (min_ != null && max_ != null && sort != null && cls != null) {
            window.location.href = 'package?cls_=' + cls + '&min_=' + min_ + '&max_=' + max_ + '&sort_=' +
                sort + '&sub_=' + subs;
        }
        if (min_ != null && max_ != null && sort != null && cls != null && q != '') {
            window.location.href = 'package?cls_=' + cls + '&min_=' + min_ + '&max_=' + max_ + '&sort_=' +
                sort + '&sub_=' + subs + '&q_=' + q;
        }
    });

    $('#class_type, #courses_type').select2({
        placeholder: "Choose",
        allowClear: true
    });
    $('#class_type').on('change', function () {
        window.location.href = 'package?cls_=' + $(this).val();
    })

    $("#price_range_btn").on("click", function () {
        event.preventDefault();
        let urlParams = new URLSearchParams(window.location.search),
            cls = urlParams.get('cls_'),
            sub = urlParams.get('sub_'),
            sort = urlParams.get('sort_'),
            q = $('#package_search_input').val(),
            min_ = $('.noUi-handle-lower').attr('aria-valuetext').split('.')[0],
            max_ = $('.noUi-handle-upper').attr('aria-valuetext').split('.')[0];
        if (cls != null) {
            window.location.href = 'package?cls_=' + cls + '&min_=' + min_ + '&max_=' + max_;
        }
        if (cls != null && q != '') {
            window.location.href = 'package?cls_=' + cls + '&min_=' + min_ + '&max_=' + max_  + '&q_=' + q;
        }
        if (sort != null && cls != null) {
            window.location.href = 'package?cls_=' + cls + '&sort_=' + sort + '&min_=' + min_ + '&max_=' + max_;
        }
        if (sort != null && cls != null && q != '') {
            window.location.href = 'package?cls_=' + cls + '&sort_=' + sort + '&min_=' + min_ + '&max_=' + max_ + '&q_=' + q;
        }
        if (sort != null && cls != null && sub != null) {
            window.location.href = 'package?cls_=' + cls + '&sort_=' + sort + '&sub_=' + sub + '&min_=' + min_ +
                '&max_=' + max_;
        }
        if (sort != null && cls != null && sub != null && q != '') {
            window.location.href = 'package?cls_=' + cls + '&sort_=' + sort + '&sub_=' + sub + '&min_=' + min_ +
                '&max_=' + max_ + '&q_=' + q;
        }
    });

</script>
<script>
    var keypressSlider = document.querySelector("#slider-range");
    var input0 = document.querySelector("#range-price-min");
    var input1 = document.querySelector("#range-price-max");
    var inputs = [input0, input1];
    var min = "{{Request::get('min_') ? Request::get('min_') : 1}}";
    var max = "{{Request::get('max_') ? Request::get('max_') : 10000}}";

    noUiSlider.create(keypressSlider, {
        start: [min, max],
        connect: true,
        step: 1,
        range: {
            min: [1],
            max: [10000]
        }
    });

    /* begin Inputs  */

    /* end Inputs  */
    keypressSlider.noUiSlider.on("update", function (values, handle) {
        inputs[handle].value = values[handle];

        /* begin Listen to keypress on the input */
        function setSliderHandle(i, value) {
            var r = [null, null];
            r[i] = value;
            keypressSlider.noUiSlider.set(r);
        }

        // Listen to keydown events on the input field.
        inputs.forEach(function (input, handle) {
            input.addEventListener("change", function () {
                setSliderHandle(handle, this.value);
            });

            input.addEventListener("keydown", function (e) {
                var values = keypressSlider.noUiSlider.get();
                var value = Number(values[handle]);

                // [[handle0_down, handle0_up], [handle1_down, handle1_up]]
                var steps = keypressSlider.noUiSlider.steps();

                // [down, up]
                var step = steps[handle];

                var position;

                // 13 is enter,
                // 38 is key up,
                // 40 is key down.
                switch (e.which) {
                    case 13:
                        setSliderHandle(handle, this.value);
                        break;

                    case 38:
                        // Get step to go increase slider value (up)
                        position = step[1];

                        // false = no step is set
                        if (position === false) {
                            position = 1;
                        }

                        // null = edge of slider
                        if (position !== null) {
                            setSliderHandle(handle, value + position);
                        }

                        break;

                    case 40:
                        position = step[0];

                        if (position === false) {
                            position = 1;
                        }

                        if (position !== null) {
                            setSliderHandle(handle, value - position);
                        }

                        break;
                }
            });
        });
        /* end Listen to keypress on the input */
    });

</script>
@endsection
