@extends('layouts.admin')
@section('css')
    <link href="{{ asset('admin/assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('page_header')
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Leaderboard</li>
            </ol>
        </nav>
{{--        <div class="col-sm-8 header-title p-0">--}}
{{--            <div class="media">--}}
{{--                <div class="header-icon text-success mr-3"><i class="typcn typcn-spiral"></i></div>--}}
{{--                <div class="media-body">--}}
{{--                    <h1 class="font-weight-bold">Leaderboard</h1>--}}
{{--                    <small>Assign Students to Teachers for examining the Answer Scripts</small>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="col-sm-8 header-title p-0">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12 col-md-6 col-sm-12">
                        <center>
                            <form class="form-inline addons mb-3" method="GET">
                                <input class="form-control" type="search" placeholder="Search Courses" aria-label="Search"
                                       style="width: 90% !important;" name="p_">
                                <button class="btn my-2 my-sm-0" type="submit"><i class="ti-search"></i></button>
                            </form>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="dashboard_container">
                <div class="dashboard_container_body">
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead class="thead-dark">
                            <tr>
                                <th >Serial No.</th>
                                <th >Name</th>
                                <th >Package Name</th>
                                <th >Marks</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($leadboards as $leadboard)
                                <tr class="text-left">
                                    <td >#{{ $leadboard->serial_number }}</td>
                                    <td>{{ $leadboard->user ? $leadboard->user->name : '' }}</td>
                                    <td>{{ $leadboard->package ? $leadboard->package->title : '' }}</td>
                                    <td>{{ $leadboard->points }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">No data found!</td>
                                </tr>
                            @endforelse

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
    <script src="{{ asset('admin/assets/plugins/datatables/dataTables.min.js')}}"></script>
    <script src="{{ asset('admin/assets/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
@endsection
@section('custom_js')
    <script>
        $('.basic').DataTable({
            iDisplayLength: 20,
            language: {
                oPaginate: {
                    sNext: '<i class="ti-angle-right"></i>',
                    sPrevious: '<i class="ti-angle-left"></i>'
                }
            }
        });

    </script>
@endsection
