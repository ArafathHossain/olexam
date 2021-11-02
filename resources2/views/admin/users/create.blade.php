@extends('layouts.admin')
@section('css')
<link href="{{ asset('admin/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
<link href="{{ asset('admin/assets/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{ asset('admin/assets/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet">
<link href="http://bhulua.thememinister.com/assets/dist/css/select.css" rel="stylesheet" type="text/css" />
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
                <h1 class="font-weight-bold">All Roles</h1>
                <small>From now on you will start your activities.</small>
            </div>
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="card mb-4">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h6 class="fs-17 font-weight-600 mb-0">Create Role</h6>
            </div>
            <div class="text-right">
                <div class="actions">
                    <a href="{{ route('admin.users.index') }}" class="action-item"><i
                            class="fas fa-angle-left mr-2"></i>Back</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="font-weight-600">Name</label>
                            <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                id="name" aria-describedby="emailHelp" placeholder="Name" name="name">
                            @if ($errors->has('name'))
                            <div class="text-danger">
                                {{ $errors->first('name') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email" class="font-weight-600">Email</label>
                            <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                id="email" aria-describedby="emailHelp" placeholder="email" name="email">
                            @if ($errors->has('email'))
                            <div class="text-danger">
                                {{ $errors->first('email') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password" class="font-weight-600">Password</label>
                            <input type="text" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                id="password" aria-describedby="emailHelp" placeholder="password" name="password">
                            @if ($errors->has('password'))
                            <div class="text-danger">
                                {{ $errors->first('password') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="roles" class="font-weight-600">Roles</label>
                            <select class="form-control testselect2" multiple="multiple" name="roles[]">
                                @foreach($roles as $id => $roles)
                                <option value="{{ $id }}"
                                    {{ (in_array($id, old('roles', [])) || isset($user) && $user->roles->contains($id)) ? 'selected' : '' }}>
                                    {{ $roles }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('roles'))
                            <div class="text-danger">
                                {{ $errors->first('roles') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Photo</label>
                            <input type="file"
                                class="custom-input-file custom-input-file--2 {{ $errors->has('photo') ? 'is-invalid' : '' }}"
                                name="photo" id="photo" />
                            <label for="photo">
                                <i class="fa fa-upload"></i>
                                <span>Upload Image</span>
                            </label>
                            @if ($errors->has('photo'))
                            <div class="text-danger">
                                {{ $errors->first('photo') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="about" class="font-weight-600">About</label>
                            <textarea class="form-control" name="about" id="about"
                                rows="5">{!! old('about') !!}</textarea>
                            @if ($errors->has('about'))
                            <div class="text-danger">
                                {{ $errors->first('about') }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="status" checked value="on" name="status">
                    <label class="form-check-label" for="status">Status</label>
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>

        </div>
    </div>
    @endsection
    @section('js')
    <!-- Third Party Scripts(used by this page)-->
    {{-- <script src="{{ asset('admin/assets/plugins/select2/dist/js/select2.min.js')}}"></script> --}}
    <script src="{{ asset('admin/assets/plugins/jquery.sumoselect/jquery.sumoselect.min.js')}}"></script>
    {{-- <script src="{{ asset('admin/assets/dist/js/pages/demo.select2.js')}}"></script> --}}
    <script src="{{ asset('admin/assets/dist/js/pages/demo.jquery.sumoselect.js')}}"></script>
    {{-- <script src="{{ asset('admin/assets/dist/js/pages/newsletter.active.js')}}"></script> --}}
    @endsection
