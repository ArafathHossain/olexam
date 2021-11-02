@extends('layouts.admin')

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
                <h1 class="font-weight-bold">All Roles</h1>
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
            <h2 class="fs-18 font-weight-bold mb-0">Responsive tables</h2>
            <a href="{{ route('admin.roles.create') }}" class="btn btn-success rounded-pill w-100p mb-2 mr-1">
                <i class="fas fa-plus mr-2"></i>Add
            </a>
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table display table-bordered table-striped table-hover bg-white m-0 card-table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Role Name</th>
                            <th>Permissions</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $id = 1;
                        @endphp
                        @foreach ($roles as $role)
                        <tr>
                            <td>
                                {{ $id++ }}
                            </td>
                            <td>{{ $role->name }}</td>
                            <td>
                                @foreach($role->permissions()->pluck('name') as $permission)
                                <span class="badge badge-pill badge-success text-uppercase">{{ $permission }}</span>
                                @endforeach
                            </td>
                            <td>
                                @if ($role->name != 'super-admin')
                                {{-- <a href="tables_bootstrap.html#" class="btn btn-success-soft btn-sm mr-1"><i
                                        class="far fa-eye"></i></a> --}}
                                @can('can-edit')
                                <a href="{{ route('admin.roles.edit', $role->id) }}"
                                    class="btn btn-info-soft btn-sm mr-1"><i class="far fa-edit"></i></a>
                                @endcan
                                @can('can-delete')
                                <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST"
                                    class="d-inline">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button type="submit" class="btn btn-danger-soft btn-sm"
                                        onclick="return confirm('Are you sure?')">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </form>
                                @endcan
                                @else
                                <p class="text-danger">Default Role Can't Modifier</p>
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
<script src="{{ asset('admin/assets/dist/js/pages/bootstrap-table.active.js')}}"></script>
@endsection