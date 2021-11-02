@extends('layouts.frontend')
@section('content')
<!-- ========================== Class Subjects Section Starts =============================== -->
<section class="bg-light">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-6 col-sm-12">
                <div class="sec-heading center">
                    <p>All Subjects</p>
                    <h2><span class="theme-cl">Primary Level:</span> {{ word_view($class->name) }}</h2>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            @foreach ($class->subjects as $subject)
            <div class="col-lg-4 col-md-4 col-sm-6">
                <a href="{{ route('package', 'cls_='.$class->id . '&sub_=' . $subject->id) }}">
                    <div class="edu_cat_2 cat-1" style="background: rgba({{$subject->color}},0.1)">
                        <div class="edu_cat_icons">
                            <img
                                    src="{{asset(''. $subject->photo)}}" class="img-fluid" alt="" />
                        </div>
                        <div class="edu_cat_data">
                            <h4 class="title" style="color: rgb({{$subject->color}})">{{word_view($subject->name)}}</h4>
                            <ul class="meta">
                                <li class="video"><i
                                        class="ti-video-clapper"></i>{{$subject->packages->where('class_id', $class->id)->count()}}
                                    Classes</li>
                            </ul>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

    </div>
</section>
<!-- ========================== Class Subjects Section Ends =============================== -->
@endsection
