@extends('layouts.admin')
@section('custom_css')
<!--<style>
    .ql-snow .ql-tooltip {
        z-index: 99 !important;
    }
    .ql-container {
        max-height: 250px;
    }
    .small-quill .ql-container {
        max-height: 100px;
    }

</style>-->
@section('page_header')
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Update MCQ</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-spiral"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Update MCQ</h1>
                <small>Update Your Question Set Here.</small>
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
                <h6 class="fs-17 font-weight-600 mb-0">Update MCQ</h6>
            </div>
            <div class="text-right">
                <div class="actions">
                    <a href="{{ route('admin.main-mcqs.index') }}" class="action-item"><i
                            class="fas fa-angle-left mr-2"></i>Back</a>
                </div>
            </div>
        </div>
        <div class="card-body">

            <main-mcq-update sl="{{ $mcq->sl }}" title="{{ $mcq->title }}" db_id="{{ $mcq->dynamic_id }}"
                :row_mcq="{{ $mcq->row_mcq }}" id="{{ $mcq->id }}" time="{{ $mcq->time }}" video="{{ $mcq->optional }}"
                subject_id="{{ $mcq->subject_id }}"></main-mcq-update>

        </div>
    </div>
    @endsection
    @section('js')
    <script src="{{ asset('admin/assets/dist/js/pages/forms-basic.active.js') }}"></script>
    @endsection
    {{-- @section('custom_js')
    <script>
        window.onbeforeunload = function (e) {
            var message = "Your confirmation message goes here.",
                e = e || window.event;
            if (e) {
                e.returnValue = message;
            }
            return message;
        };

    </script>
    @endsection --}}
