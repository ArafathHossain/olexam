@extends('layouts.frontend')
@section('content')
<!-- ============================ Page Title Start================================== -->
<section class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">

                <div class="breadcrumbs-wrap">
                    <h1 class="breadcrumb-title">Checkout</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Checkout</li>
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
            <div class="col-lg-8 col-md-12">


                <div class="cart_totals checkout light_form">
                    <h4>Select Payment Methode</h4>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="choose_payment_mt active">
                                <img src="{{ asset('images/mastercard.png') }}" alt="" />
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="choose_payment_mt">
                                <img src="{{ asset('images/paypal.png') }}" alt="" />
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="choose_payment_mt">
                                <img src="{{ asset('images/visa.png') }}" alt="" />
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <label>Card Number</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>

                        <div class="col-lg-7 col-md-7">
                            <div class="form-group">
                                <label>Card Holder</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3">
                            <div class="form-group">
                                <label>Expiry Date</label>
                                <input type="text" class="form-control" placeholder="mm/dd/yyyy">
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-2">
                            <div class="form-group">
                                <label>CVC</label>
                                <input type="text" class="form-control" placeholder="cvc">
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <button type="button" class="btn btn-theme full-width">Proceed To Checkout</button>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <div class="col-lg-4 col-md-12">
                <!-- Total Cart -->
                <div class="cart_totals checkout">
                    <h4>Order Summary</h4>
                    <div class="cart-wrap">
                        <ul class="cart_list">
                            <li>Base price<strong>{{ currency_type($sub_total) }}</strong></li>
                            <li>Discount<strong>{{ currency_type($discount) }}</strong></li>
                        </ul>
                        <div class="flex_cart">
                            <div class="flex_cart_1">
                                Total Cost
                            </div>
                            <div class="flex_cart_2">
                                {{ currency_type($total) }}
                            </div>
                        </div>
                        <button type="button" class="btn checkout_btn">Proceed To Checkout</button>
                    </div>
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
