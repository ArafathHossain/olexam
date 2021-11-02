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

<!-- =================================== FAQS =================================== -->
<section class="pt-0">
    <div class="container">

        <div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12">

                <div class="property_block_wrap_header">
                    <ul class="nav nav-tabs customize-tab tabs_creative justify-content-center" id="myTab"
                        role="tablist">
                        @foreach ($faqs as $key => $faq)
                        <li class="nav-item">
                            <a class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{ $key }}-tab" data-toggle="tab"
                                href="#{{ $key }}" role="tab" aria-controls="{{ $key }}"
                                aria-selected="{{ $loop->first ? true : false }}">{!! word_view($key) !!}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="tab-content tabs_content_creative" id="myTabContent">
                    @php
                        $g_id = 0;
                    @endphp
                    @foreach ($faqs as $key => $faq)
                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $key }}" role="tabpanel" aria-labelledby="{{ $key }}-tab">
                        <div class="accordion" id="{{ $key }}-{{ $g_id }}">
                            @foreach ($faq as $k =>  $item)                            
                            <div class="card">
                                <div class="card-header" id="{{ $key }}-heading-{{ $k }}">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse"
                                            data-target="#{{ $key }}-collapse-{{ $k }}" aria-expanded="true" aria-controls="{{ $key }}-collapse-{{ $k }}">
                                           {!! $item->title !!}
                                        </button>
                                    </h2>
                                </div>

                                <div id="{{ $key }}-collapse-{{ $k }}" class="collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="{{ $key }}-heading-{{ $k }}"
                                    data-parent="#{{ $key }}-{{ $g_id }}">
                                    <div class="card-body">
                                        <p class="ac-para">
                                            {!! $item->content !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                    </div>
                    @php
                        $g_id++;
                    @endphp
                    @endforeach
                   

                </div>

            </div>

        </div>
    </div>
</section>
<!-- ====================================== FAQS =================================== -->
@endsection