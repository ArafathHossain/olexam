@extends('layouts.frontend')
@section('content')
    <!-- ============================ Page Title Start================================== -->
    <section class="page-title">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">

                    <div class="breadcrumbs-wrap">
                        <h1 class="breadcrumb-title">Add To cart</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Add To cart</li>
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
                    <div class="table-responsive">
                        <table class="table add_to_cart">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Price</th>
                                {{-- <th scope="col">Quantity</th> --}}
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($cart_items as $item)
                                <tr>
                                    <td>
                                        <div class="tb_course_thumb"><img
                                                src="{{ asset('' . $item->attributes->photo) }}"
                                                class="img-fluid" alt=""/></div>
                                    </td>
                                    <th>{{ $item->name }}<span
                                            class="tb_date">{{ Carbon\Carbon::parse($item->associatedModel->created_at)->isoFormat('MMM Do YY') }}</span>
                                    </th>
                                    <td><span class="wish_price theme-cl">{{ currency_type($item->price) }}</span></td>
                                    <td>
                                        <form action="{{ route('remove_cart', $item->id ) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-remove" id="item_remove">Remove
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>

                    <!-- Coupon Apply -->
                    <div class="checkout_coupon checkout">
                        <div class="checkout_coupon_flex">
                            <form class="form-inline" action="{{ route('apply.coupon') }}" method="POST">
                                @csrf
                                <label>
                                    <input class="form-control" type="search" placeholder="Coupon Code" name="coupon">
                                </label>
                                <button type="submit" class="btn btn-theme2 ml-2">Apply Coupon</button>
                            </form>
                            @if ($errors->has('coupon'))
                                <div class="text-danger d">
                                    {{ $errors->first('coupon') }}
                                </div>
                            @endif
                        </div>
                        <div class="ckt_last d-flex">

                            <form action="{{ route('cart.empty') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn empty_btn">Empty cart</button>
                            </form>
                        </div>
                    </div>


                </div>

                <div class="col-lg-4 col-md-12">
                    <!-- Total Cart -->
                    <div class="cart_totals checkout">
                        <h4>Billing Summary</h4>
                        <div class="cart-wrap">
                            <ul class="cart_list">
                                <li>Base price<strong>{{ currency_type(Cart::getSubTotalWithoutConditions()) }}</strong>
                                </li>
                                <li>
                                    Discount <strong>
                                        - {{ currency_type(Cart::getSubTotalWithoutConditions() - Cart::getSubTotal()) }}
                                    </strong></li>
                            </ul>
                            <div class="flex_cart">
                                <div class="flex_cart_1">
                                    Total Cost
                                </div>
                                <div class="flex_cart_2">
                                    {{ currency_type(Cart::getTotal()) }}
                                </div>
                            </div>
                            @php
                                $payLink = Auth::user()->charge(Cart::getTotal(), 'Enrollment', [
                                    "passthrough" => [
                                    	'enrollment_type' => 'package',
                                        'package_ids' => collect($cart_items)->pluck('id')->toArray()
                                    ]
                                ]);
                            @endphp
                            {{-- <a href="{{ route('checkout') }}" class="btn checkout_btn">Proceed To Checkout</a> --}}
{{--                            <form action="{{ url('/checkout/pay') }}" method="post">--}}
{{--                                @csrf--}}
{{--                                <button type="submit" class="btn checkout_btn w-100"> Pay Now--}}
{{--                                </button>--}}
{{--                            </form>--}}
                            <x-paddle-button :url="$payLink" class="btn checkout_btn w-100" data-theme="none">
                                Pay with Card/Paypal
                            </x-paddle-button>

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
@endsection
@section('custom_js')

    <script>
        function openNav() {
            document.getElementById("filter-sidebar").style.width = "320px";
        }

        function closeNav() {
            document.getElementById("filter-sidebar").style.width = "0";
        }

        // $('#sslczPayBtn').prop('postdata', obj);

        // (function (window, document) {
        //     var loader = function () {
        //         var script = document.createElement("script"),
        //             tag = document.getElementsByTagName("script")[0];
        //         // script.src = "https://seamless-epay.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(7); // USE THIS FOR LIVE
        //         script.src = "https://sandbox.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(7); // USE THIS FOR SANDBOX
        //         tag.parentNode.insertBefore(script, tag);
        //     };

        //     window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload",
        //         loader);
        // })(window, document);

    </script>

@endsection
