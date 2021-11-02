@extends('layouts.admin')
@section('css')
    <link href="{{ asset('admin/assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('page_header')
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Role</li>
            </ol>
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-spiral"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">All Students</h1>
                    <small>From now on you will start your activities.</small>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="fs-18 font-weight-bold mb-0">Student tables</h2>
                <a href="{{ route('admin.users.create') }}" class="btn btn-success rounded-pill w-100p mb-2 mr-1">
                    <i class="fas fa-plus mr-2"></i>Add
                </a>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table display table-bordered table-striped table-hover basic">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $id = 1;
                        @endphp
                        @foreach ($students as $student)
                            <tr>
                                <td>{{ $id++ }}</td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->email }}</td>
                                <td>
                                    {{ $student->phone ?? "N/A" }}
                                </td>
                                <td>
                                    @if ($student->status == 1)
                                        <span class="badge badge-info">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <!-- Third Party Scripts(used by this page)-->
    <script src="{{ asset('admin/assets/plugins/sparkline/sparkline.min.js')}}"></script>
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
