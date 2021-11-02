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
                                    <li class="breadcrumb-item active" aria-current="page">Courses Stats</li>
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
{{--                                <div class="dashboard_container_header">--}}
{{--                                    <div class="dashboard_fl_1">--}}
{{--                                        <h4>All Courses</h4>--}}
{{--                                    </div>--}}
{{--                                    <div class="dashboard_fl_2">--}}
{{--                                        <ul class="mb0">--}}
{{--                                            <li class="list-inline-item">--}}

{{--                                            </li>--}}
{{--                                            <li class="list-inline-item">--}}
{{--                                                <form class="form-inline my-2 my-lg-0">--}}
{{--                                                    <input class="form-control" type="search" placeholder="Search Courses"--}}
{{--                                                           aria-label="Search">--}}
{{--                                                    <button class="btn my-2 my-sm-0" type="submit"><i--}}
{{--                                                            class="ti-search"></i></button>--}}
{{--                                                </form>--}}
{{--                                            </li>--}}
{{--                                        </ul>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                <div class="dashboard_container_body">
                                    <!-- Single Course -->
                                    <canvas id="myChart"></canvas>

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.2.0/chart.min.js" integrity="sha512-VMsZqo0ar06BMtg0tPsdgRADvl0kDHpTbugCBBrL55KmucH6hP9zWdLIWY//OTfMnzz6xWQRxQqsUFefwHuHyg==" crossorigin="anonymous"></script>
@endsection
@section('custom_js')
    <script>
        $('#side-menu').metisMenu();

        var ctx = document.getElementById("myChart");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: @json($datasets)
            },
            options: {
                animations: {
                    tension: {
                        duration: 1000,
                        easing: 'linear',
                        from: 1,
                        to: 0,
                        loop: false
                    }
                },
                scales: {
                    y: {
                        min: 0,
                        max: 100
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var label = context.dataset.label +": " + context.parsed.y;

                                if (context.dataset.label === "User's Points") {
                                    label += "%";
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });

    </script>
@endsection
