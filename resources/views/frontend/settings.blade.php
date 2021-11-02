@extends('layouts.frontend')
@section('content')

<!-- ============================ Dashboard: My Order Start ================================== -->
<section class="gray pt-0">
    <div class="container-fluid">

        <!-- Row -->
        <div class="row">

            @include('partials.student_dashboard_sidebar')

            <div class="col-lg-9 col-md-9 col-sm-12">

                <!-- Row -->
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 pt-4 pb-4">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Settings</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!-- /Row -->

                <!-- Row -->
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="dashboard_container">
                            @if(session()->get('success'))
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ session()->get('success') }} </strong>
                            </div>
                            @endif
                            <div class="dashboard_container_header">
                                <div class="dashboard_fl_1">
                                    <h4>Setup Your Detail</h4>
                                </div>
                            </div>
                            <div class="dashboard_container_body p-4">
                                <form action="{{ route('user.update', auth()->user()->id) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <!-- Basic info -->
                                    <div class="submit-section">
                                        <div class="form-row">

                                            <div class="form-group col-md-6">
                                                <label>Your Name</label>
                                                <input type="text" class="form-control" name="name"
                                                    value="{{ auth()->user()->name }}">
                                                @if ($errors->has('name'))
                                                <div class="text-danger">
                                                    {{ $errors->first('name') }}
                                                </div>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>Email</label>
                                                <input type="email" class="form-control" name="email"
                                                    value="{{ auth()->user()->email }}">
                                                @if ($errors->has('email'))
                                                <div class="text-danger">
                                                    {{ $errors->first('email') }}
                                                </div>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>Phone</label>
                                                <input type="text" class="form-control" name="phone"
                                                    value=" {{ auth()->user()->phone }}">
                                                @if ($errors->has('phone'))
                                                <div class="text-danger">
                                                    {{ $errors->first('phone') }}
                                                </div>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>Address</label>
                                                <input type="text" class="form-control" name="address"
                                                    value="{{ auth()->user()->address }}">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>City/State</label>
                                                <input type="text" class="form-control" name="city"
                                                    value="{{ auth()->user()->city }}">
                                            </div>


                                            <div class="form-group col-md-6">
                                                <label>Zip</label>
                                                <input type="text" class="form-control" name="zip"
                                                    value="{{ auth()->user()->zip }}">
                                            </div>
                                            <div class=" col-md-6">
                                                <div class="form-group">
                                                    <label>Photo</label>
                                                    <input type="file" onchange="photo_edit(event)" class="form-control"
                                                        name="photo">
                                                </div>
                                                <img id="user_photo_get" width="100"
                                                    src="{{ asset(''. auth()->user()->photo) }}" alt="">
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label>About</label>
                                                <textarea class="form-control"
                                                    name="about">{!! auth()->user()->about !!}</textarea>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- Basic info -->

                                    <!-- Social Account info -->
                                    <div class="form-submit">
                                        <h4 class="pl-2 mt-2">Academic Informations</h4>
                                        <div class="submit-section">
                                            <div class="form-row">

                                                <div class="form-group col-md-6">
                                                    <label for="">Grade</label>
                                                    <!-- <input type="text" class="form-control" name="grad"
                                                        value="{{ auth()->user()->grad }}"> -->
                                                    @php
                                                    $class = DB::table('student_classes')->select('id', 'name')->get();
                                                    @endphp
                                                    <select id="courses_type" class="form-control" name="grad">
                                                        <option value="">Select</option>
                                                        @foreach ($class as $item)
                                                        <option value="{{ $item->id }}" {{ auth()->user()->grad == $item->id ? 'selected' : '' }}>{{ word_view($item->name) }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('grad'))
                                                    <div class="text-danger">
                                                        {{ $errors->first('grad') }}
                                                    </div>
                                                    @endif
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label>Favourite Subject</label>
                                                    <input type="text" class="form-control" name="favourite_subject"
                                                        value="{{ auth()->user()->favourite_subject }}">
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label>Github/Google Drive</label>
                                                    <input type="text" class="form-control" name="github"
                                                        placeholder="https://github.com/abcd"
                                                        value="{{ auth()->user()->github }}">
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label>LinkedIn</label>
                                                    <input type="text" class="form-control" name="linkedin"
                                                        placeholder="https://www.linkedin.com/abcd"
                                                        value="{{ auth()->user()->linkedin }}">
                                                </div>

                                                <div class="form-group col-lg-12 col-md-12">
                                                    <button class="btn btn-theme" type="submit">Update</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- / Social Account info -->
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- /Row -->

            </div>

        </div>
        <!-- Row -->

    </div>
</section>
<!-- ============================ Dashboard: My Order Start End ================================== -->
@endsection
@section('js')
<!-- ============================================================== -->
<!-- This page plugins -->
<!-- ============================================================== -->
<script src="{{ asset('js/metisMenu.min.js') }}"></script>
<script>
    $(document).ready(function () {

        $('#side-menu').metisMenu();
    });

</script>
@endsection
@section('custom_js')
<script>
    function photo_edit(e) {
        let file = e.target.files[0];
        let reader = new FileReader();
        if (file["size"] < 2111775) {
            reader.onloadend = (file) => {
                document.getElementById('user_photo_get').src = reader.result;
            };
            reader.readAsDataURL(file);
        } else {
            alert("File size can not be bigger than 2 MB");
        }
    }

</script>
@endsection
