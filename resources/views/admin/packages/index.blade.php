@extends('layouts.admin')
@section('css')
<link href="{{ asset('admin/assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('page_header')
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Packages</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-spiral"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">All Packages</h1>
                <small>Create & View Packages Here.</small>
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
            <h2 class="fs-18 font-weight-bold mb-0">List of Packages</h2>
            <a href="{{ route('admin.packages.create') }}" class="btn btn-success rounded-pill w-100p mb-2 mr-1">
                <i class="fas fa-plus mr-2"></i>Add New Package
            </a>
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

            <div class="table-responsive">
                <table class="table display table-bordered table-striped table-hover basic">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Create By</th>
                            <th>Title</th>
                            <th>Class</th>
                            <th>Subject</th>
                            <th>Type</th>
                            {{-- <th>MCQ Sets</th> --}}
                            <th>Create Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $id = 1;
                        @endphp
                        @foreach ($all_packages as $package)
                        <tr>
                            <td>
                                {{ $id++ }}
                            </td>
                            <td>
                                @if ($package->user)
                                {{ $package->user->name }}
                                @endif
                            </td>
                            <td>
                                {{ $package->title }}
                            </td>
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
                                {{-- @foreach($class->subjects()->pluck('name') as $subject)
                                <span class="badge badge-pill badge-info text-uppercase">{{ $subject }}</span>
                                @endforeach --}}
                            </td>
                            <td>
                                {{-- @foreach($package->mcqs()->pluck('title') as $mcq)
                                <span class="badge badge-pill badge-info text-uppercase">{{ $mcq }}</span>
                                @endforeach --}}
                                {{-- {{ $package->created_at->diffForHumans() ?? "" }} --}}
                                {{ format_date_time($package->created_at, 'M-d-Y') }}
                            </td>
                            <td>

                                {{-- <a href="tables_bootstrap.html#" class="btn btn-success-soft btn-sm mr-1"><i
                                        class="far fa-eye"></i></a> --}}
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

    $('#class_id').change(function (e) {
        const path = window.location.pathname;
        window.location.href = path+"?class_id="+e.target.value;
    })

</script>
@endsection
