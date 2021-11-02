@extends('layouts.admin')
@section('css')
<link href="{{ asset('admin/assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('page_header')
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Classes</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-spiral"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">All Classes</h1>
                <small>Create Classes Here..</small>
            </div>
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="col-lg-12">
    <div class="card">
        @if(session()->get('success'))
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ session()->get('success') }} </strong>
        </div>
        @endif
        @if(session()->get('error'))
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ session()->get('error') }} </strong>
        </div>
        @endif
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="fs-18 font-weight-bold mb-0">List of Classes</h2>
            <a href="{{ route('admin.classes.create') }}" class="btn btn-success rounded-pill w-100p mb-2 mr-1">
                <i class="fas fa-plus mr-2"></i>Add New Class
            </a>
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table display table-bordered table-striped table-hover basic">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Subjects</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $id = 1;
                        @endphp
                        @foreach ($all_classes as $class)
                        <tr>
                            <td>
                                {{ $id++ }}
                            </td>
                            <td>{{ $class->name }}</td>
                            <td>
                                {{$class->slug}}
                            </td>
                            <td>
                                @foreach($class->subjects()->pluck('name') as $subject)
                                <span class="badge badge-pill badge-info text-uppercase">{{ $subject }}</span>
                                @endforeach

                            </td>
                            <td>

                                {{-- <a href="tables_bootstrap.html#" class="btn btn-success-soft btn-sm mr-1"><i
                                        class="far fa-eye"></i></a> --}}
                                @can('can-edit')
                                <a href="{{ route('admin.classes.edit', $class->id) }}"
                                    class="btn btn-info-soft btn-sm mr-1"><i class="far fa-edit"></i></a>
                                @endcan
                                @can('can-delete')
                                <form action="{{ route('admin.classes.destroy', $class->id) }}" method="POST"
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