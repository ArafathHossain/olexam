<!-- ============================ Footer Start ================================== -->
<footer class="dark-footer skin-dark-footer">
    <div>
        <div class="container">
            <div class="row">

                <div class="col-lg-3 col-md-3">
                    <div class="footer-widget">
                        <img src="/{{ site_setting('footer_logo') }}" class="img-footer" alt="" />
                        <div class="footer-add">
                            <p>{!! site_setting('address', 'Dhaka, Bangladesh') !!}</p>
                            <p>{!! site_setting('phone', '+1 234-567-8910') !!}</p>
                            <p>{!! site_setting('email', 'info@onlinelivemcq.com') !!}</p>
                        </div>

                    </div>
                </div>
                @if (!empty($footers_list['column_two']))
                <div class="col-lg-3 col-md-3">
                    <div class="footer-widget">
                        <h4 class="widget-title">{!! $footers_list['column_two']->first()->title !!}</h4>
                        @php
                            $link = explode('||',$footers_list['column_two']->first()->link);
                            $name = explode('||',$footers_list['column_two']->first()->name);
                        @endphp
                        <ul class="footer-menu">
                            @foreach ($name as $key =>  $item)
                            <li><a href="{{ url($link[$key]) }}">{{ word_view($item) }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif
                @if (!empty($footers_list['column_three']))
                <div class="col-lg-3 col-md-3">
                    <div class="footer-widget">
                        <h4 class="widget-title">{!! $footers_list['column_three']->first()->title !!}</h4>
                        @php
                            $link = explode('||',$footers_list['column_three']->first()->link);
                            $name = explode('||',$footers_list['column_three']->first()->name);
                        @endphp
                        <ul class="footer-menu">
                            @foreach ($name as $key =>  $item)
                            <li><a href="{{ url($link[$key]) }}">{{ word_view($item) }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif
                @if (!empty($footers_list['column_four']))
                <div class="col-lg-3 col-md-3">
                    <div class="footer-widget">
                        <h4 class="widget-title">{!! $footers_list['column_four']->first()->title !!}</h4>
                        @php
                            $link = explode('||',$footers_list['column_four']->first()->link);
                            $name = explode('||',$footers_list['column_four']->first()->name);
                        @endphp
                        <ul class="footer-menu">
                            @foreach ($name as $key =>  $item)
                            <li><a href="{{ url($link[$key]) }}">{{ word_view($item) }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-lg-6 col-md-6">
                    <p class="mb-0">{!! site_setting('copyright', '© 2020 OLM - Online Live MCQ. ') !!}</p>
                </div>

                <div class="col-lg-6 col-md-6 text-right">
                    <ul class="footer-bottom-social">
                        <li><a href="{{ site_setting('fb_link', '#') }}"><i class="ti-facebook"></i></a></li>
                        <li><a href="{{ site_setting('tw_link','#') }}"><i class="ti-twitter"></i></a></li>
                        <li><a href="{{ site_setting('in_link','#') }}"><i class="ti-instagram"></i></a></li>
                        <li><a href="{{ site_setting('ld_link','#') }}"><i class="ti-linkedin"></i></a></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</footer>
<!-- ============================ Footer End ================================== -->