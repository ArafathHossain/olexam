@extends('layouts.frontend')
@section('content')
<!-- ============================ Page Title Start================================== -->
<section class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">

                <div class="breadcrumbs-wrap">
                    <h1 class="breadcrumb-title">Product Wishlist</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Wishlist</li>
                        </ol>
                    </nav>
                </div>

            </div>
        </div>
    </div>
</section>
<!-- ============================ Page Title End ================================== -->


<!-- ============================ Add To cart ================================== -->
<section class="pt-0">
    <div class="container">

        <div class="row">
            <div class="col-md-12 col-lg-12">

                <div class="table-responsive">
                    <table class="table table-striped wishlist">
                        <tbody>
                            <tr>
                                <th scope="row"><a href="#" class="remove_cart"><i class="ti-close"></i></a></th>
                                <td>
                                    <div class="tb_course_thumb"><img src="{{ asset('images/course-1.jpg') }}" class="img-fluid"
                                            alt="" /></div>
                                </td>
                                <th>The Computer Science of Human Decisions<span class="tb_date">18 july 2020</span>
                                </th>
                                <td><span class="wish_price theme-cl">$149.00</span></td>
                                <td>In Stock</td>
                                <td><a href="#" class="btn btn-add_cart">Add To Cart</a></td>
                            </tr>
                            <tr>
                                <th scope="row"><a href="#" class="remove_cart"><i class="ti-close"></i></a></th>
                                <td>
                                    <div class="tb_course_thumb"><img src="{{ asset('images/course-2.jpg') }}" class="img-fluid"
                                            alt="" /></div>
                                </td>
                                <th>The Computer Science of Human Decisions<span class="tb_date">15 july 2020</span>
                                </th>
                                <td><span class="wish_price theme-cl">$129.00</span></td>
                                <td>In Stock</td>
                                <td><a href="#" class="btn btn-add_cart">Add To Cart</a></td>
                            </tr>
                            <tr>
                                <th scope="row"><a href="#" class="remove_cart"><i class="ti-close"></i></a></th>
                                <td>
                                    <div class="tb_course_thumb"><img src="{{ asset('images/course-3.jpg') }}" class="img-fluid"
                                            alt="" /></div>
                                </td>
                                <th>The Computer Science of Human Decisions<span class="tb_date">13 july 2020</span>
                                </th>
                                <td><span class="wish_price theme-cl">$125.00</span></td>
                                <td>In Stock</td>
                                <td><a href="#" class="btn btn-add_cart">Add To Cart</a></td>
                            </tr>
                            <tr>
                                <th scope="row"><a href="#" class="remove_cart"><i class="ti-close"></i></a></th>
                                <td>
                                    <div class="tb_course_thumb"><img src="{{ asset('images/course-4.jpg') }}" class="img-fluid"
                                            alt="" /></div>
                                </td>
                                <th>The Computer Science of Human Decisions<span class="tb_date">12 july 2020</span>
                                </th>
                                <td><span class="wish_price theme-cl">$179.00</span></td>
                                <td>In Stock</td>
                                <td><a class="btn btn-add_cart" href="#">Add To Cart</a></td>
                            </tr>
                            <tr>
                                <th scope="row"><a href="#" class="remove_cart"><i class="ti-close"></i></a></th>
                                <td>
                                    <div class="tb_course_thumb"><img src="{{ asset('images/course-5.jpg') }}" class="img-fluid"
                                            alt="" /></div>
                                </td>
                                <th>The Computer Science of Human Decisions<span class="tb_date">11 july 2020</span>
                                </th>
                                <td><span class="wish_price theme-cl">$180.00</span></td>
                                <td>In Stock</td>
                                <td><a href="#" class="btn btn-add_cart">Add To Cart</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
</section>
<!-- ============================ Add To cart End ================================== -->

<!-- ============================================================== -->
<!-- This page plugins -->
<!-- ============================================================== -->
<script>
    function openNav() {
        document.getElementById("filter-sidebar").style.width = "320px";
    }

    function closeNav() {
        document.getElementById("filter-sidebar").style.width = "0";
    }

</script>
@endsection
