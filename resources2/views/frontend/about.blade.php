@extends('layouts.frontend')
@section('content')
<!-- ============================ Page Title Start================================== -->
<section class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                {{-- Breadcrumbs --}}
                @include('partials.breadcrumbs')

            </div>
        </div>
    </div>
</section>
<!-- ============================ Page Title End ================================== -->

<!-- ========================== About Facts List Section =============================== -->
<section class="pt-0">
    <div class="container">

        <div class="row align-items-center">

            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="list_facts_wrap">
                    <div class="sec-heading mb-3">
                        <h2>{!! $about->title !!}</h2>
                    </div>
                    @php
                    $icon = explode('||', $about->list_icon);
                    $title = explode('||', $about->list_title);
                    $content = explode('||', $about->list_content);
                    @endphp
                    @foreach ($icon as $key =>  $item)                        
                    <div class="list_facts">
                        <div class="list_facts_icons">{!! $item !!}</div>
                        <div class="list_facts_caption">
                            <h4>{!! !empty($title[$key]) ? $title[$key] : '' !!}</h4>
                            <p>{!! !empty($content[$key]) ? $content[$key] : '' !!}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="list_facts_wrap_img">

                    <img src="{{ asset($about->photo) }}" class="img-fluid" alt="" />

                </div>
            </div>

        </div>

    </div>
</section>
<!-- ========================== About Facts List Section =============================== -->
@endsection
