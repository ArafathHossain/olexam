@extends('layouts.admin')
@section('css')
<link href="{{ asset('admin/assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('page_header')
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Manage Result</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-spiral"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Manage Result</h1>
                <small>Review the Answer Scripts and Update the Marks.</small>
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
            <h2 class="fs-18 font-weight-bold mb-0">List of Answer Scripts</h2>

        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="class_id" class="font-weight-600">Select Class</label>
                        <select id="class_id"
                                class="form-control basic-single {{ $errors->has('class_id') ? 'is-invalid' : '' }}"
                                name="class_id">

                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" @if($loop->first) selected @endif>{{ $class->name }}</option>
                            @endforeach

                        </select>
                        @if ($errors->has('class_id'))
                            <div class="text-danger">
                                {{ $errors->first('class_id') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="package_id" class="font-weight-600">Select Package</label>
                        <select id="package_id"
                                class="form-control basic-single {{ $errors->has('package_id') ? 'is-invalid' : '' }}"
                                name="package_id">

                        </select>
                        @if ($errors->has('package_id'))
                            <div class="text-danger">
                                {{ $errors->first('package_id') }}
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
                            <th>User Name</th>
                            <th>MCQ</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tboday">
{{--                        @php--}}
{{--                        $id = 1;--}}
{{--                        @endphp--}}
{{--                        @foreach ($all_exams as $exam)--}}
{{--                        <tr>--}}
{{--                            <td>--}}
{{--                                {{ $id++ }}--}}
{{--                            </td>--}}
{{--                            <td>--}}
{{--                                {{  $exam->user ? $exam->user->name : '' }}--}}
{{--                            </td>--}}
{{--                            <td>--}}
{{--                                {{ $exam->mcq ? $exam->mcq->title : '' }}--}}
{{--                            </td>--}}
{{--                            <td>--}}
{{--                                 <a href="{{ route('admin.get.exam', $exam->id) }}"--}}
{{--                                class="btn btn-info-soft btn-sm mr-1"><i class="far fa-edit"></i></a>--}}
{{--                                @can('can-edit')--}}
{{--                                <a href="{{ route('admin.exam.get', $exam->id) }}"--}}
{{--                                    class="btn btn-success-soft btn-sm mr-1"><i class="far fa-eye"></i></a>--}}
{{--                                @endcan--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                        @endforeach--}}
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

    let selectedClassId = $('#class_id').val();

    const packages = @json($packages);
    const all_exams = @json($all_exams);
    let html = '';
    renderPackageOptions(packages, selectedClassId);
    function renderPackageOptions(packages, classId) {
        html = '<option value>Select Package</option>';
        const filteredPackages = packages.filter(p => p.class_id == classId);
        console.log(filteredPackages, classId, packages)
        for (i = 0; i < filteredPackages.length; i++) {
            html += `<option value=${filteredPackages[i].id}>${filteredPackages[i].title}</option>`
        }
        $('#package_id').html(html);
    }

    $('#class_id').change(function (e) {
        renderPackageOptions(packages, e.target.value);
    })
    let tbody = '';

    $('#package_id').change(function (e) {
        tbody = '';

        const exams = all_exams.filter(ex => ex.package_id == e.target.value);

        for(i =0; i < exams.length; i++) {
            const name = exams[i].user ? exams[i].user.name : '';
            const title = exams[i].mcq ? exams[i].mcq.title : '';
            const id = exams[i].id;
            tbody += `
            <tr>
            <td>
               ${i + 1}
            </td>
            <td>
                ${name}
            </td>
            <td>
            ${title}
            </td>
            <td>
            @can('can-edit')
            <a href=result-manage/get-exam/${id}
                                    class="btn btn-success-soft btn-sm mr-1"><i class="far fa-eye"></i></a>
            @endcan
            </td>
        </tr>
`
        }

        $('#tboday').html(tbody);
    })

</script>
@endsection
