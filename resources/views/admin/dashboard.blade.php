@extends('layouts.admin')
@section('css')
<!--Third party Styles(used by this page)-->
<link href="{{ asset('admin/assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endsection
@section('page_header')
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="index.html#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-spiral"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Dashboard</h1>
                <small>From now on you will start your activities.</small>
            </div>
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="row">
{{--    <div class="col-lg-12 col-xl-6">--}}
{{--        <div class="card mb-4">--}}
{{--            <div class="card-body text-center">--}}
{{--                <div class="row justify-content-center">--}}
{{--                    <div class="greet-user col-12 col-xl-10">--}}
{{--                        <img src="{{ asset('admin/assets/dist/img/happiness.svg')}}" alt="..." class="img-fluid  mb-2">--}}
{{--                        <h2 class="fs-23 font-weight-600 mb-2">--}}
{{--                            Congratulations John,--}}
{{--                        </h2>--}}
{{--                        <p class="text-muted">--}}
{{--                            You have done 57.6% more sales today. Check your new badge in your profile.--}}
{{--                        </p>--}}
{{--                        <a href="index.html#!" class="btn btn-success">--}}
{{--                            Try it for free--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
    <div class="col-lg-12">
        <div class="row">
            <div class="col-md-6 col-lg-6 col-xl-4">
                <!--Revenue today indicator-->
                <div class="p-2 bg-white rounded p-3 mb-3 shadow-sm">
                    <div class="header-pretitle text-muted fs-11 font-weight-bold text-uppercase mb-2">
                        Revenue Today
                    </div>
                    <div class="badge badge-success fs-26 text-monospace mx-auto">${{$today_revenue}}<span
                            class="opacity-50 small">.00</span></div>
                    <div class="text-muted small mt-1">
{{--                        <span class="text-danger">--}}
{{--                            <i class="fas fa fa-long-arrow-alt-down"></i>--}}
{{--                            5%--}}
{{--                        </span> vs average--}}
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-4">
                <!--This Month Revenue-->
                <div class="p-2 bg-white rounded p-3 mb-3 shadow-sm">
                    <div class="header-pretitle text-muted fs-11 font-weight-bold text-uppercase mb-2">
                        Revenue This Month
                    </div>
                    <div class="badge badge-success fs-26 text-monospace mx-auto">${{$current_month_revenue}}<span
                            class="opacity-50 small">.00</span></div>
                    <div class="text-muted small mt-1">
{{--                        <span class="text-danger">--}}
{{--                            <i class="fas fa fa-long-arrow-alt-down"></i>--}}
{{--                            5%--}}
{{--                        </span> vs average--}}
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-4">
                <!--This Year Revenue-->
                <div class="p-2 bg-white rounded p-3 mb-3 shadow-sm">
                    <div class="header-pretitle text-muted fs-11 font-weight-bold text-uppercase mb-2">
                        Revenue This Year
                    </div>
                    <div class="badge badge-success fs-26 text-monospace mx-auto">${{$current_year_revenue}}<span
                            class="opacity-50 small">.00</span></div>
                    <div class="text-muted small mt-1">
{{--                        <span class="text-danger">--}}
{{--                            <i class="fas fa fa-long-arrow-alt-down"></i>--}}
{{--                            5%--}}
{{--                        </span> vs average--}}
                    </div>
                </div>
            </div>
{{--            <div class="col-md-6 col-lg-6 col-xl-4">--}}
{{--                <!--Time on site indicator-->--}}
{{--                <div class="d-flex flex-column p-3 mb-3 bg-white shadow-sm rounded">--}}
{{--                    <div class="header-pretitle text-muted fs-11 font-weight-bold text-uppercase mb-2">avg time on site--}}
{{--                    </div>--}}
{{--                    <div class="d-flex align-items-center">--}}
{{--                        <i class="fas fa fa-clock opacity-25 mr-2 text-size-3"></i>--}}
{{--                        <span class="text-size-2 text-monospace">10</span>--}}
{{--                        <span class="text-size-2">m</span>--}}
{{--                        <span class="text-size-2 text-monospace">30</span>--}}
{{--                        <span class="text-size-2">s</span>--}}
{{--                    </div>--}}
{{--                    <div class="text-muted small">--}}
{{--                        <span class="text-success text-monospace">--}}
{{--                            <i class="fas fa fa-long-arrow-alt-up"></i>--}}
{{--                            5%--}}
{{--                        </span> vs last week--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-md-6 col-lg-6 col-xl-4">--}}
{{--                <!--Top Referrals-->--}}
{{--                <div class="d-flex flex-column p-3 mb-3 bg-white shadow-sm rounded">--}}
{{--                    <div class="header-pretitle text-muted fs-11 font-weight-bold text-uppercase mb-2">Top Referrals--}}
{{--                    </div>--}}
{{--                    <div>--}}
{{--                        <i class="fas fa fa-caret-up text-success"></i>--}}
{{--                        <span class="mx-1 text-monospace">62%</span>--}}
{{--                        <!--           <i class="fab fa-xs fa-google"></i>  -->--}}
{{--                        <a href="index.html#">google</a>--}}
{{--                    </div>--}}
{{--                    <div class="opacity-75">--}}
{{--                        <i class="fas fa fa-caret-down text-danger"></i>--}}
{{--                        <span class="text-secondary mx-1 text-monospace">25%</span>--}}
{{--                        <!--           <i class="fab fa-xs fa-y-combinator"></i>  -->--}}
{{--                        <a href="index.html#">news.ycombinator</a>--}}
{{--                    </div>--}}
{{--                    <div class="opacity-50">--}}
{{--                        <i class="text-muted">–</i>--}}
{{--                        <span class="text-secondary mx-1 text-monospace">20%</span>--}}
{{--                        <!--           <i class="fab fa-xs fa-product-hunt"></i>  -->--}}
{{--                        <a href="index.html#">producthunt</a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-md-6 col-lg-6 col-xl-4">--}}
{{--                <!--Sessions by device-->--}}
{{--                <div class="d-flex flex-column p-3 mb-3 bg-white shadow-sm rounded">--}}
{{--                    <div class="header-pretitle text-muted fs-11 font-weight-bold text-uppercase mb-2">Sessions by--}}
{{--                        device</div>--}}
{{--                    <div class="row text-center">--}}
{{--                        <div class="col">--}}
{{--                            <i class="fas fa fa-mobile mb-2 text-size-2"></i>--}}
{{--                            <div class="text-monospace">54%</div>--}}
{{--                        </div>--}}
{{--                        <div class="col">--}}
{{--                            <i class="fas fa fa-tablet opacity-50 mb-2 text-size-2"></i>--}}
{{--                            <div class="text-monospace text-secondary">26%</div>--}}
{{--                        </div>--}}
{{--                        <div class="col">--}}
{{--                            <i class="fas fa fa-laptop opacity-25 mb-2 text-size-2"></i>--}}
{{--                            <div class="text-monospace text-secondary">20%</div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
    </div>
</div>
<div class="row">
{{--    <div class="col-md-12 col-lg-12 col-xl-3 mb-4">--}}
{{--        <div class="card">--}}
{{--            <div class="card-header">--}}
{{--                <div class="d-flex justify-content-between align-items-center">--}}
{{--                    <div>--}}
{{--                        <h6 class="fs-17 font-weight-600 mb-0">Pie Chart</h6>--}}
{{--                    </div>--}}
{{--                    <div class="text-right">--}}
{{--                        <div class="actions">--}}
{{--                            <a href="index.html#" class="action-item"><i class="ti-reload"></i></a>--}}
{{--                            <div class="dropdown action-item" data-toggle="dropdown">--}}
{{--                                <a href="index.html#" class="action-item"><i class="ti-more-alt"></i></a>--}}
{{--                                <div class="dropdown-menu dropdown-menu-right">--}}
{{--                                    <a href="index.html#" class="dropdown-item">Refresh</a>--}}
{{--                                    <a href="index.html#" class="dropdown-item">Manage Widgets</a>--}}
{{--                                    <a href="index.html#" class="dropdown-item">Settings</a>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="card-body">--}}
{{--                <div class="chart mb-3">--}}
{{--                    <canvas id="doughutChart" height="310"></canvas>--}}
{{--                </div>--}}
{{--                <div class="chart-legend">--}}
{{--                    <div class="chart-legend-item">--}}
{{--                        <div class="chart-legend-color kelly-green"></div>--}}
{{--                        <p>From Google</p>--}}
{{--                        <p class="percentage text-muted">63.259 %</p>--}}
{{--                    </div>--}}
{{--                    <div class="chart-legend-item">--}}
{{--                        <div class="chart-legend-color kelly-green2"></div>--}}
{{--                        <p>Your Website</p>--}}
{{--                        <p class="percentage text-muted">25.321 %</p>--}}
{{--                    </div>--}}
{{--                    <div class="chart-legend-item">--}}
{{--                        <div class="chart-legend-color whisper"></div>--}}
{{--                        <p>Others</p>--}}
{{--                        <p class="percentage text-muted">11.42 %</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="col-md-12 col-lg-12 col-xl-9">--}}
{{--        <div class="card mb-4">--}}
{{--            <div class="card-header">--}}
{{--                <h2 class="fs-18 font-weight-bold mb-0">Bar chart</h2>--}}
{{--            </div>--}}
{{--            <div class="card-body">--}}
{{--                <canvas id="barChart" height="128"></canvas>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}


    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0">Package List</h6>
                    </div>
                    <div class="text-right">
                        <div class="actions">
                            <a href="index.html#" class="action-item"><i class="ti-reload"></i></a>
                            <div class="dropdown action-item" data-toggle="dropdown">
                                <a href="index.html#" class="action-item"><i class="ti-more-alt"></i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="index.html#" class="dropdown-item">Refresh</a>
                                    <a href="index.html#" class="dropdown-item">Manage Widgets</a>
                                    <a href="index.html#" class="dropdown-item">Settings</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="class_id" class="font-weight-600">Select Class</label>
                            <select id="class_id"
                                    class="form-control basic-single {{ $errors->has('class_id') ? 'is-invalid' : '' }}"
                                    name="class_id">
                                <option value="">Choose Class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" @if(\request()->get('class_id') == $class->id) selected @endif>{{ $class->name }}</option>
                                @endforeach

                            </select>
                            @if ($errors->has('class_id'))
                                <div class="text-danger">
                                    {{ $errors->first('class_id') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class=table-responsive>
                    <!--<table class="table table-sm table-nowrap card-table">-->
                    <table class="table display table-bordered table-striped table-hover bg-white m-0 card-table">
                        <thead>
                            <tr>
                                <th>Create By</th>
                                <th>Title</th>
                                <th>Class</th>
                                <th>Subject</th>
                                <th>Type</th>
                                 <th>Total Enrolled</th>
                                <th>Create Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($all_packages as $package)
                            <tr>
                                <td>
                                    @if ($package->user)
                                        {{ $package->user->name }}
                                    @endif
                                </td>
                                <td>{{ $package->title }}</td>
                                <td>
                                    @if ($package->class)
                                        {{ $package->class->name }}
                                    @endif
                                </td>
                                <td>
                                    @if ($package->subject)
                                        {{ $package->subject->name }}
                                    @endif
                                </td>
                                <td>
                                    @if ($package->package_type == 1)
                                        <span class="badge badge-success">Premium</span>
                                    @else
                                        <span class="badge badge-info">Free</span>
                                    @endif
                                </td>
                                <td>{{ $package->enrolls_count }}</td>
                                <td>{{ format_date_time($package->created_at, 'M-d-Y') }}</td>
                                <td>
                                    @can('can-edit')
                                        <a href="{{ route('admin.packages.edit', $package->id) }}"
                                           class="btn btn-info-soft btn-sm mr-1"><i class="far fa-edit"></i></a>
                                    @endcan
                                    @can('can-delete')
                                        <form action="{{ route('admin.packages.destroy', $package->id) }}" method="POST"
                                              class="d-inline">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit" class="btn btn-danger-soft btn-sm"
                                                    onclick="return confirm('Are you sure?')">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@section('js')
<!-- Third Party Scripts(used by this page)-->
<script src="{{ asset('admin/assets/plugins/chartJs/Chart.min.js')}}"></script>
<script src="{{ asset('admin/assets/plugins/sparkline/sparkline.min.js')}}"></script>
<script src="{{ asset('admin/assets/plugins/datatables/dataTables.min.js')}}"></script>
<script src="{{ asset('admin/assets/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
<!--Page Active Scripts(used by this page)-->
<script src="{{ asset('admin/assets/dist/js/pages/dashboard.js')}}"></script>
 <script type="text/javascript">
     $('#class_id').change(function (e) {
         const path = window.location.pathname;
         window.location.href = path+"?class_id="+e.target.value;
     })
 </script>

@endsection
