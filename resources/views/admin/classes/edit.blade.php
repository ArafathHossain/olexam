@extends('layouts.admin')
@section('css')

{{-- <link href="{{ asset('admin/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
<link href="{{ asset('admin/assets/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">
--}}

<link href="{{ asset('admin/assets/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet">
@endsection
@section('page_header')
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Update Class</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-spiral"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Update Class</h1>
                <small>Update Classes Here..</small>
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
                <h6 class="fs-17 font-weight-600 mb-0">Update Class</h6>
            </div>
            <div class="text-right">
                <div class="actions">
                    <a href="{{ route('admin.classes.index') }}" class="action-item"><i
                            class="fas fa-angle-left mr-2"></i>Back</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.classes.update', $class->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="font-weight-600">Class Name</label>
                            <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                id="name" aria-describedby="emailHelp" placeholder="Name" name="name"
                                value="{{ $class->name }}">
                            @if ($errors->has('name'))
                            <div class="text-danger">
                                {{ $errors->first('name') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="font-weight-600">Select Subjects</label>
                            <select multiple="multiple" class="form-control select2" name="subjects[]">
                                <option disabled="disabled" selected="selected" value="">Select</option>
                                @foreach($subjects as $key => $subject)
                                <option value="{{ $subject->id }}"
                                    {{ (in_array($subject->id, $class->subjects->pluck('id')->toArray() )) ? 'selected' : '' }}>
                                    {{ word_view($subject->name) }}
                                </option>
                                @endforeach
                            </select>
                            @if ($errors->has('subjects'))
                            <div class="text-danger">
                                {{ $errors->first('subjects') }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-info">Update</button>
            </form>

        </div>
    </div>
</div>
@endsection
@section('js')
{{-- <script src="{{ asset('admin/assets/plugins/select2/dist/js/select2.min.js')}}"></script> --}}
<script src="{{ asset('admin/assets/plugins/jquery.sumoselect/jquery.sumoselect.min.js')}}"></script>
@endsection
@section('custom_js')
<script>
    $('.select2').SumoSelect({
        selectAll: true, 
        search: true
    });

</script>
@endsection
