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
                                <li class="breadcrumb-item active" aria-current="page">My orders</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!-- /Row -->

                <!-- Row -->
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="dashboard_container">
                            <div class="dashboard_container_header">
                                <div class="dashboard_fl_1">
                                    <h4>View Order</h4>
                                </div>
                            </div>
                            <div class="dashboard_container_body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">Order</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Total</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $order)
                                            <tr>
                                                <th scope="row">#{{ $order->id }}</th>
                                                <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}
                                                </td>
                                                <td><span class="payment_status 
														{{( $order->status == 'Processing' || $order->status == 'Complete') ? 'complete' : ''}}
														 {{$order->status == 'Pending' ? 'pending' : '' }}
														 {{$order->status == 'Canceled' ? 'cancel' : '' }}
														 ">{{ $order->status }}</span>
                                                </td>
                                                <td>{{ $order->package_type == 0 ? 'Free' : currency_type($order->total) }}
                                                </td>
                                                <td>
                                                    <div class="dash_action_link d-flex">
                                                        @if ($order->status == 'Pending')
                                                        <form action="{{ url('/checkout/order/'. $order->id) }}"
                                                            method="post">
                                                            @csrf
                                                            <button type="submit" class="view btn btn-success">Pay
                                                                Now</button>
                                                        </form>
                                                        <form action="{{ url('/checkout/order/cancel/'. $order->id) }}"
                                                            method="post">
                                                            @csrf
                                                            <button type="submit"
                                                                class="cancel btn btn-danger ml-2">Cancel</button>
                                                        </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
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

<!-- ============================================================== -->
<!-- This page plugins -->
<!-- ============================================================== -->
<script src="asset/js/metisMenu.min.js"></script>
<script>
    $('#side-menu').metisMenu();

</script>

@endsection
