@extends('layouts.admin')
@section('css')

<link href="{{ asset('admin/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
<link href="{{ asset('admin/assets/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">


{{-- <link href="{{ asset('admin/assets/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet"> --}}
{{-- <link href="http://bhulua.thememinister.com/assets/dist/css/select.css" rel="stylesheet" type="text/css" /> --}}

@endsection
@section('page_header')
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Create Footer Widget</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-spiral"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Create Footer Widget</h1>
                <small>From now on you will start your activities.</small>
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
                <h6 class="fs-17 font-weight-600 mb-0">Create Footer Widget</h6>
            </div>
            <div class="text-right">
                <div class="actions">
                    <a href="{{ route('admin.footers.index') }}" class="action-item"><i
                            class="fas fa-angle-left mr-2"></i>Back</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.footers.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="column" class="font-weight-600">Select Column</label>
                            <select id="column"
                                class="form-control basic-single {{ $errors->has('column') ? 'is-invalid' : '' }}"
                                name="column">
                                <option disabled="disabled" selected="selected" value="">Select</option>
                                @foreach(footer_column() as $column)
                                <option value="{{ $column }}" {{ old('column')  ? 'selected' : '' }}>
                                    {{ word_view($column) }}
                                </option>
                                @endforeach
                            </select>
                            @if ($errors->has('column'))
                            <div class="text-danger">
                                {{ $errors->first('column') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title" class="font-weight-600">Widget Title</label>
                            <input type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                id="title" aria-describedby="emailHelp" placeholder="title" name="title"
                                value="{{ old('title') }}">
                            @if ($errors->has('title'))
                            <div class="text-danger">
                                {{ $errors->first('title') }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row menu_item_clone">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="font-weight-600">Menu Name</label>
                            <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                id="name" aria-describedby="emailHelp" placeholder="name" name="name[]">
                            @if ($errors->has('name.*'))
                            <div class="text-danger">
                                {{ $errors->first('name.*') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="link" class="font-weight-600">Menu Link ( If there is no link # )</label>
                            {{-- <input type="text" class="form-control {{ $errors->has('link') ? 'is-invalid' : '' }}"
                            id="link" aria-describedby="emailHelp" placeholder="link" name="link[]"> --}}
                            <select class="form-control {{ $errors->has('link.*') ? 'is-invalid' : '' }}" name="link[]">
                                @foreach(site_links() as $link => $name)
                                <option value="{{ $link }}">
                                    {{ word_view($name) }}
                                </option>
                                @endforeach
                                @foreach($pages as $link)
                                <option value="/page/{{ $link->slug }}">
                                    {{ word_view($link->title) }}
                                </option>
                                @endforeach
                            </select>
                            @if ($errors->has('link.*'))
                            <div class="text-danger">
                                {{ $errors->first('link.*') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12 text-right">
                        <div class="delete_btn text-right">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <button type="button" id="add_item" class="btn btn-info btn-sm ">Add
                            New</button>
                    </div>
                </div>
                <button type="submit" class="btn btn-success ">Submit</button>
            </form>

        </div>
    </div>
</div>
@endsection
@section('js')
<script src="{{ asset('admin/assets/plugins/select2/dist/js/select2.min.js')}}"></script>
{{-- <script src="{{ asset('admin/assets/plugins/jquery.sumoselect/jquery.sumoselect.min.js')}}"></script> --}}
@endsection
@section('custom_js')
<script>
    $(".basic-single").select2({
        search: true
    });

    $(document).on('click', '#add_item', function () {
        $('.menu_item_clone:first').clone().insertAfter(".menu_item_clone:last").find('.delete_btn').append(
            '<button type="button" class=" delete_item btn btn-danger btn-sm">Delete</button>');
    }).on('click', '.delete_item', function () {
        $(this).closest('.menu_item_clone').remove();
    });

</script>
@endsection