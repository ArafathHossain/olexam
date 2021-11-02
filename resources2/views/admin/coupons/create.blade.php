@extends('layouts.admin')
@section('css')

<link href="{{ asset('admin/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
<link href="{{ asset('admin/assets/plugins/daterangepicker/daterangepicker.css')}}" rel="stylesheet">
{{-- <link href="{{ asset('admin/assets/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}"
rel="stylesheet"> --}}

{{-- <link href="{{ asset('admin/assets/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet"> --}}
{{-- <link href="http://bhulua.thememinister.com/assets/dist/css/select.css" rel="stylesheet" type="text/css" /> --}}

@endsection
@section('page_header')
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Create Coupon</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-spiral"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Create Coupon</h1>
                <small>Creat Coupon Here.</small>
            </div>
        </div>
    </div>
</div>
@endsection
@section('content')
{{-- <div class="col-md-6 mx-auto">


</div> --}}
<div class="card mb-4">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h6 class="fs-17 font-weight-600 mb-0">Create Coupon</h6>
            </div>
            <div class="text-right">
                <div class="actions">
                    <a href="{{ route('admin.coupons.index') }}" class="action-item"><i
                            class="fas fa-angle-left mr-2"></i>Back</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.coupons.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="code" class="font-weight-600">Coupon Code</label>
                            <input type="text" class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}"
                                id="code" aria-describedby="emailHelp" placeholder="Name" name="code"
                                value="{{ old('code') }}">
                            @if ($errors->has('code'))
                            <div class="text-danger">
                                {{ $errors->first('code') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="type" class="font-weight-600">Coupon Type</label>
                            <select class="form-control basic-single" name="type" id="type">
                                <option disabled="disabled" selected="selected" value="">Select</option>
                                @foreach(coupon_type() as $type)
                                <option value="{{ $type }}" {{ old('type') ? 'selected' : '' }} >
                                    {{ word_view($type) }}
                                </option>
                                @endforeach
                            </select>
                            @if ($errors->has('type'))
                            <div class="text-danger">
                                {{ $errors->first('type') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="discount" class="font-weight-600">Coupon Discount</label>
                            <input type="text" class="form-control {{ $errors->has('discount') ? 'is-invalid' : '' }}"
                                id="discount" name="discount" value="{{ old('discount') }}">
                            @if ($errors->has('discount'))
                            <div class="text-danger">
                                {{ $errors->first('discount') }}
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="date" class="font-weight-600">Coupon Expiration Date</label>
                            <input type="text" class="form-control {{ $errors->has('date') ? 'is-invalid' : '' }}"
                                id="date" name="date" value="{{ old('date') }}">
                            @if ($errors->has('date'))
                            <div class="text-danger">
                                {{ $errors->first('date') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="user" class="font-weight-600">Limit User</label>
                            <input type="text" class="form-control {{ $errors->has('user') ? 'is-invalid' : '' }}"
                                id="user" name="user" value="{{ old('user') }}">
                            @if ($errors->has('user'))
                            <div class="text-danger">
                                {{ $errors->first('user') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="min_buy" class="font-weight-600">Minimum Purchase Amount</label>
                            <input type="text" class="form-control {{ $errors->has('min_buy') ? 'is-invalid' : '' }}"
                                id="min_buy" name="min_buy" value="{{ old('min_buy') }}">
                            @if ($errors->has('min_buy'))
                            <div class="text-danger">
                                {{ $errors->first('min_buy') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="student_class_id" class="font-weight-600">Select Class</label>
                            <select class="form-control basic-single" name="student_class_id" id="student_class_id">
                                <option disabled="disabled" selected="selected" value="">Select</option>
                                @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ old('student_class_id') ? 'selected' : '' }} >
                                    {{ word_view($class->name) }}
                                </option>
                                @endforeach
                            </select>
                            @if ($errors->has('student_class_id'))
                            <div class="text-danger">
                                {{ $errors->first('student_class_id') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="checkbox checkbox-success pl-0">
                                <input id="status" type="checkbox" name="status" value="on" checked>
                                <label for="status">Active</label>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Save</button>
            </form>

        </div>
    </div>
</div>
@endsection
@section('js')
<script src="{{ asset('admin/assets/plugins/select2/dist/js/select2.min.js')}}"></script>
<script src="{{ asset('admin/assets/plugins/moment/moment.js')}}"></script>
<script src="{{ asset('admin/assets/plugins/daterangepicker/daterangepicker.js')}}"></script>
{{-- <script src="{{ asset('admin/assets/plugins/jquery.sumoselect/jquery.sumoselect.min.js')}}"></script> --}}
@endsection
@section('custom_js')
<script>
    $(".basic-single").select2();
    $('input[name="date"]').daterangepicker({
        singleDatePicker: true,
        locale: {
            format: 'YYYY-MM-DD'
        }

        // showDropdowns: true,
    });

</script>
@endsection
