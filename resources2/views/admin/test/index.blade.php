@extends('layouts.admin')
@section('css')
{{-- <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet"> --}}
@endsection
@section('content')
<example-component></example-component>
@endsection
@section('js')
    <script src="{{ asset('admin/assets/dist/js/pages/forms-basic.active.js') }}"></script>
    {{-- <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script> --}}
@endsection
@section('custom_js')
<script>

    // var quill = new Quill('.ques_form_title', {
    //     theme: 'snow'
    //   });
</script>
@endsection