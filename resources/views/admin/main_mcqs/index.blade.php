@extends('layouts.admin')

@section('page_header')
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">MCQ</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-spiral"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">All MCQ</h1>
                <small>Create & View Question Sets Here.</small>
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
            <h2 class="fs-18 font-weight-bold mb-0">List of Question Sets</h2>
            <a href="{{ route('admin.main-mcqs.create') }}" class="btn btn-success rounded-pill w-100p mb-2 mr-1">
                <i class="fas fa-plus mr-2"></i>Add New Question Set
            </a>
        </div>
        <div class="card-body">
            {{-- {{ dd('[{"field_id":567,"questions_title":"Untitled Questions","questions_photo":"","questions_type":[{"value":"shot_questions_1","name":"Short Answer"},{"value":"paragraph_questions_2","name":"Paragraph"},{"value":"multiple_questions_3","name":"Multiple Choice"},{"value":"file_questions_4","name":"File Upload"}],"select_type":"multiple_questions_3","options":[{"option_id":567,"input_name":"Option","input_photo":"","ans":false},{"option_id":568,"input_name":"Option","input_photo":"","ans":false},{"option_id":569,"input_name":"Option","input_photo":"","ans":false},{"option_id":570,"input_name":"Option","input_photo":"","ans":false}],"ans":[],"points":0,"shouldDisable":true,"ans_mode":false},{"field_id":568,"questions_title":"Untitled Questions","questions_photo":"","questions_type":[{"value":"shot_questions_1","name":"Short Answer"},{"value":"paragraph_questions_2","name":"Paragraph"},{"value":"multiple_questions_3","name":"Multiple Choice"},{"value":"file_questions_4","name":"File Upload"}],"select_type":"shot_questions_1","options":[{"option_id":571,"input_name":"Option","input_photo":"","ans":false}],"ans":[],"points":0,"shouldDisable":true,"ans_mode":false},{"field_id":569,"questions_title":"Untitled Questions","questions_photo":"","questions_type":[{"value":"shot_questions_1","name":"Short Answer"},{"value":"paragraph_questions_2","name":"Paragraph"},{"value":"multiple_questions_3","name":"Multiple Choice"},{"value":"file_questions_4","name":"File Upload"}],"select_type":"paragraph_questions_2","options":[{"option_id":572,"input_name":"Option","input_photo":"","ans":false}],"ans":[],"points":0,"shouldDisable":true,"ans_mode":false},{"field_id":570,"questions_title":"Untitled Questions","questions_photo":"","questions_type":[{"value":"shot_questions_1","name":"Short Answer"},{"value":"paragraph_questions_2","name":"Paragraph"},{"value":"multiple_questions_3","name":"Multiple Choice"},{"value":"file_questions_4","name":"File Upload"}],"select_type":"file_questions_4","options":[{"option_id":573,"input_name":"Option","input_photo":"","ans":false}],"ans":[],"points":0,"shouldDisable":true,"ans_mode":false}]') }}
            {{ dd('[{"field_id":567,"questions_title":"Untitled Questions","questions_photo":"","questions_type":[{"value":"shot_questions_1","name":"Short Answer"},{"value":"paragraph_questions_2","name":"Paragraph"},{"value":"multiple_questions_3","name":"Multiple Choice"},{"value":"file_questions_4","name":"File Upload"}],"select_type":"multiple_questions_3","options":[{"option_id":567,"input_name":"Option","input_photo":"","ans":false},{"option_id":568,"input_name":"Option","input_photo":"","ans":false},{"option_id":569,"input_name":"Option","input_photo":"","ans":false},{"option_id":570,"input_name":"Option","input_photo":"","ans":false}],"ans":[],"points":0,"shouldDisable":true,"ans_mode":false},{"field_id":568,"questions_title":"Untitled Questions","questions_photo":"","questions_type":[{"value":"shot_questions_1","name":"Short Answer"},{"value":"paragraph_questions_2","name":"Paragraph"},{"value":"multiple_questions_3","name":"Multiple Choice"},{"value":"file_questions_4","name":"File Upload"}],"select_type":"shot_questions_1","options":[{"option_id":571,"input_name":"Option","input_photo":"","ans":false}],"ans":[],"points":0,"shouldDisable":true,"ans_mode":false},{"field_id":569,"questions_title":"Untitled Questions","questions_photo":"","questions_type":[{"value":"shot_questions_1","name":"Short Answer"},{"value":"paragraph_questions_2","name":"Paragraph"},{"value":"multiple_questions_3","name":"Multiple Choice"},{"value":"file_questions_4","name":"File Upload"}],"select_type":"paragraph_questions_2","options":[{"option_id":572,"input_name":"Option","input_photo":"","ans":false}],"ans":[],"points":0,"shouldDisable":true,"ans_mode":false},{"field_id":570,"questions_title":"Untitled Questions","questions_photo":"","questions_type":[{"value":"shot_questions_1","name":"Short Answer"},{"value":"paragraph_questions_2","name":"Paragraph"},{"value":"multiple_questions_3","name":"Multiple Choice"},{"value":"file_questions_4","name":"File Upload"}],"select_type":"file_questions_4","options":[{"option_id":573,"input_name":"Option","input_photo":"","ans":false}],"ans":[],"points":0,"shouldDisable":true,"ans_mode":false}]') }}
            --}}
            <div class="table-responsive">
                <table class="table display table-bordered table-striped table-hover bg-white m-0 card-table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>MCQ SL#</th>
                            <th>MCQ Title</th>
                            <th>Question Count</th>
                            <th>MCQ Time</th>
                            <th>Created By</th>
                            <th>Created Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $id = 1;
                        @endphp
                        @foreach ($all_mcqs as $mcq)
                        <tr>
                            <td>
                                {{ $id++ }}
                            </td>
                            <td>{{ $mcq->sl }}</td>
                            <td>{{ $mcq->title }}</td>
                            <td>{{ count(json_decode($mcq->row_mcq)) }}</td>
                            <td>{{ $mcq->time }}</td>
                            <td>
                                {{-- {{ limit_string($mcq->row_mcq, 50) }} --}}
                                {{ $mcq->user->name ?? '' }}
                            </td>
                            <td>
                                {{ format_date_time($mcq->created_at, 'M-d-Y') }}
                            </td>
                            <td>

                                @can('can-show')
                                <a href="{{ route('admin.main-mcqs.show', $mcq->id) }}"
                                    class="btn btn-success-soft btn-sm mr-1"><i class="far fa-eye"></i></a>
                                @endcan
                                @can('can-edit')
                                <a href="{{ route('admin.main-mcqs.edit', $mcq->id) }}"
                                    class="btn btn-info-soft btn-sm mr-1"><i class="far fa-edit"></i></a>
                                @endcan
                                @can('can-delete')
                                <form action="{{ route('admin.main-mcqs.destroy', $mcq->id) }}" method="POST"
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
<script src="{{ asset('admin/assets/plugins/sparkline/sparkline.min.js')}}"></script>
<script src="{{ asset('admin/assets/dist/js/pages/bootstrap-table.active.js')}}"></script>
@endsection
