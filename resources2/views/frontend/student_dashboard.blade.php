@extends('layouts.frontend')
@section('content')

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
                                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!-- /Row -->

                <!-- Row -->
                <div class="row">

                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="dashboard_stats_wrap widget-1">
                            <div class="dashboard_stats_wrap_content">
                                <h4>607</h4> <span>Listings Included</span>
                            </div>
                            <div class="dashboard_stats_wrap-icon"><i class="ti-location-pin"></i></div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="dashboard_stats_wrap widget-2">
                            <div class="dashboard_stats_wrap_content">
                                <h4>102</h4> <span>Listings Remaining</span>
                            </div>
                            <div class="dashboard_stats_wrap-icon"><i class="ti-pie-chart"></i></div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="dashboard_stats_wrap widget-4">
                            <div class="dashboard_stats_wrap_content">
                                <h4>70</h4> <span>Featured Included</span>
                            </div>
                            <div class="dashboard_stats_wrap-icon"><i class="ti-user"></i></div>
                        </div>
                    </div>

                </div>
                <!-- /Row -->

                <!-- Row -->
                <div class="row">

                    <div class="col-lg-8 col-md-12 col-sm-12">
                        <div class="row">

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="course_overlay_cat">
                                    <div class="course_overlay_cat_thumb">
                                        <a href="#" tabindex="0"><img src="{{asset('images/course-1.jpg')}}"
                                                class="img-fluid" alt=""></a>
                                    </div>
                                    <div class="course_overlay_cat_caption">
                                        <div class="llp-left">
                                            <h4><a href="#">Physics: Chapter- 1 to 5</a></h4>
                                            <span>10 MCQ Sets</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="course_overlay_cat">
                                    <div class="course_overlay_cat_thumb">
                                        <a href="#" tabindex="0"><img src="{{asset('images/course-2.jpg')}}"
                                                class="img-fluid" alt=""></a>
                                    </div>
                                    <div class="course_overlay_cat_caption">
                                        <div class="llp-left">
                                            <h4><a href="#">Chemistry: Chapter- 1 to 5</a></h4>
                                            <span>10 MCQ Sets</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="course_overlay_cat">
                                    <div class="course_overlay_cat_thumb">
                                        <a href="#" tabindex="0"><img src="{{asset('images/course-3.jpg')}}"
                                                class="img-fluid" alt=""></a>
                                    </div>
                                    <div class="course_overlay_cat_caption">
                                        <div class="llp-left">
                                            <h4><a href="#">Biology: Chapter- 1 to 5</a></h4>
                                            <span>10 MCQ Sets</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="course_overlay_cat">
                                    <div class="course_overlay_cat_thumb">
                                        <a href="#" tabindex="0"><img src="{{asset('images/course-5.jpg')}}"
                                                class="img-fluid" alt=""></a>
                                    </div>
                                    <div class="course_overlay_cat_caption">
                                        <div class="llp-left">
                                            <h4><a href="#">ICT</a></h4>
                                            <span>10 MCQ Sets</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h6>Notifications</h6>
                            </div>
                            <div class="ground-list ground-hover-list">
                                @foreach ($notifications as $notification)
                                @php
                                $a_name = '';
                                if (!empty($notification->data['admin_id'])) {
                                    $admin = App\Models\User::find($notification->data['admin_id']);
                                    if ($admin) {
                                    $a_name = $admin->name;
                                    }
                                }
                                @endphp
                                <div class="ground ground-list-single">
                                    @if (!empty($notification->data['main_mcq_id']) && !empty($notification->data['package_id']))
                                    <a href="{{ route('mcq.exam', ['package_id' => $notification->data['package_id'], 'mcq_id' => $notification->data['main_mcq_id']]). '?nid_=' . $notification->id }}">
                                        <div class="btn-circle-40 btn-success"><i class="ti-calendar"></i></div>
                                    </a>
                                    @endif

                                    <div class="ground-content">
                                        <h6>
                                            @if (!empty($notification->data['main_mcq_id']) && !empty($notification->data['package_id']))
                                            <a
                                                href="{{ route('mcq.exam', ['package_id' => $notification->data['package_id'], 'mcq_id' => $notification->data['main_mcq_id']]). '?nid_=' . $notification->id }}">
                                                Check By {{ $a_name }}
                                            </a>
                                            @endif
                                        </h6>
                                        <small
                                            class="text-fade">{{ !empty($notification->data['message'] ? $notification->data['message'] : '') }}</small>
                                        <span class="small">{{ ($notification->created_at)->diffForHumans() }}</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /Row -->

                <!-- Row -->
                {{-- <div class="row">

                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="dashboard_container">
                            <div class="dashboard_container_header">
                                <div class="dashboard_fl_1">
                                    <h4>Recent Order</h4>
                                </div>
                            </div>
                            <div class="dashboard_container_body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">Order</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Total</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">#0000149</th>
                                                <td>02 July 2020</td>
                                                <td><span class="payment_status inprogress">In Progress</span></td>
                                                <td>$110.00</td>
                                                <td>
                                                    <div class="dash_action_link">
                                                        <a href="#" class="view">View</a>
                                                        <a href="#" class="cancel">Cancel</a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">#0000150</th>
                                                <td>04 July 2020</td>
                                                <td><span class="payment_status complete">Completed</span></td>
                                                <td>$119.00</td>
                                                <td>
                                                    <div class="dash_action_link">
                                                        <a href="#" class="view">View</a>
                                                        <a href="#" class="cancel">Cancel</a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">#0000151</th>
                                                <td>07 July 2020</td>
                                                <td><span class="payment_status complete">Completed</span></td>
                                                <td>$149.00</td>
                                                <td>
                                                    <div class="dash_action_link">
                                                        <a href="#" class="view">View</a>
                                                        <a href="#" class="cancel">Cancel</a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">#0000152</th>
                                                <td>10 July 2020</td>
                                                <td><span class="payment_status pending">Pending Payment</span></td>
                                                <td>$199.00</td>
                                                <td>
                                                    <div class="dash_action_link">
                                                        <a href="#" class="view">View</a>
                                                        <a href="#" class="cancel">Cancel</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>

                </div> --}}
                <!-- /Row -->

            </div>

        </div>

    </div>
</section>
<!-- ============================ Dashboard: Dashboard End ================================== -->

@endsection
@section('js')
<!-- ============================================================== -->
<!-- This page plugins -->
<!-- ============================================================== -->
<script src="{{ asset('js/metisMenu.min.js') }}"></script>
@endsection
@section('custom_js')
<script>
    $('#side-menu').metisMenu();

</script>
@endsection
