<?php

namespace App\Http\Controllers\Frontend;

use Cart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Library\SslCommerz\SslCommerzNotification;
use App\Models\Enroll;
use App\Models\LiveEnroll;
use App\Models\LiveExam;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function checkout()
    {
        if (Cart::isEmpty()) {
            return redirect('/');
        }
        $sub_total = Cart::getSubTotalWithoutConditions();
        $total = Cart::getTotal();
        $discount = 0;
        return view('frontend.checkout', compact('sub_total', 'total', 'discount'));
    }

    public function handlePayment($id, Request $request)
    {
        dd($id, Auth::id());
        return view("");
    }

    public function live_enroll(Request $request)
    {
        $live_exam = LiveExam::find($request->live_id);

        if(!(int) $live_exam->exam_type) {
            $live_enroll = new LiveEnroll();
            $live_enroll->user_id = Auth::id();
            $live_enroll->live_exam_id = $live_exam->id;
            $live_enroll->total =$live_exam->price;
            $live_enroll->status = 'Complete';
            $live_enroll->transaction_id = uniqid();
            $live_enroll->save();
        }
        return back()->with('success', "Live Exam Enrollment success");

    }

    public function payment_url(Request $request)
    {
        $live_exam = (object)[];
        if ($request->live_id) {
            $live_exam = LiveExam::find($request->live_id);
        }
        $post_data = array();
        $post_data['total_amount'] = empty((array)$live_exam) ? Cart::getTotal() : $live_exam->price; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique
        $post_data['live_id'] = $request->live_id ? $request->live_id : '';

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Customer Name';
        $post_data['cus_email'] = 'customer@mail.com';
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '8801XXXXXXXXX';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        #Before  going to initiate the payment order status need to insert or update as Pending.
        // $enroll = DB::table('enrolls')
        //     ->where('transaction_id', $post_data['tran_id'])
        //     ->updateOrInsert([
        //         'user_id' => auth()->id(),
        //         'total' => $post_data['total_amount'],
        //         'status' => 'Pending',
        //         'transaction_id' => $post_data['tran_id'],
        //     ]);
        if (empty((array)$live_exam)) {
            $enroll = new Enroll();
            $enroll->user_id = auth()->id();
            $enroll->total = $post_data['total_amount'];
            $enroll->status = 'Pending';
            $enroll->transaction_id = $post_data['tran_id'];
            $enroll->package_type = 1;
            $enroll->save();
            // package add to enroll
            $cart_items = Cart::getContent();
            $ids = [];
            foreach ($cart_items as $key => $value) {
                array_push($ids, $value['id']);
            }
            $enroll->packages()->attach($ids);
        } else {
            $live_enroll = new LiveEnroll();
            $live_enroll->user_id = auth()->id();
            $live_enroll->live_exam_id = $live_exam->id;
            $live_enroll->total = $post_data['total_amount'];
            $live_enroll->status = 'Pending';
            $live_enroll->transaction_id = $post_data['tran_id'];
            $live_enroll->save();
        }

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
    }
    public function payment_ajax(Request $request)
    {
        $post_data = array();
        $post_data['total_amount'] = Cart::getTotal(); # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Customer Name';
        $post_data['cus_email'] = 'customer@mail.com';
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '8801XXXXXXXXX';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";


        #Before  going to initiate the payment order status need to update as Pending.
        $update_product = DB::table('enrolls')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'user_id' => auth()->id(),
                'total' => $post_data['total_amount'],
                'status' => 'Pending',
                'transaction_id' => $post_data['tran_id'],
            ]);


        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
    }

    public function payment_success(Request $request)
    {
        echo "Transaction is Successful";

        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');
        if ($enroll_info = Enroll::where('transaction_id', $tran_id)->first()) {
        } else {
            $enroll_info = LiveEnroll::where('transaction_id', $tran_id)->first();
        }
        $sslc = new SslCommerzNotification();

        #Check order status in order tabel against the transaction id or order id.
        // $order_detials = DB::table('enrolls')
        //     ->where('transaction_id', $tran_id)
        //     ->select('transaction_id', 'status', 'currency', 'total')->first();

        if ($enroll_info->status == 'Pending') {
            $validation = $sslc->orderValidate($tran_id, $amount, $currency, $request->all());

            if ($validation == TRUE) {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
                in order table as Processing or Complete.
                Here you can also sent sms or email for successfull transaction to customer
                */
                $enroll_info->update(['status' => 'Complete']);

                echo "<br >Transaction is successfully Completed";
            } else {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel and Transation validation failed.
                Here you need to update order status as Failed in order table.
                */
                $enroll_info->update(['status' => 'Failed']);
                echo "validation Fail";
            }
        } else if ($enroll_info->status == 'Processing' || $enroll_info->status == 'Complete') {
            /*
             That means through IPN Order status already updated. Now you can just show the customer that transaction is completed. No need to udate database.
             */
            echo "Transaction is successfully Completed";
        } else {
            #That means something wrong happened. You can redirect customer to your product page.
            echo "Invalid Transaction";
        }
        Toastr::success('Transaction is successfully Completed');
        return redirect('/');
    }

    public function payment_fail(Request $request)
    {
        $tran_id = $request->input('tran_id');

        if ($enroll_info = Enroll::where('transaction_id', $tran_id)->first()) {
        } else {
            $enroll_info = LiveEnroll::where('transaction_id', $tran_id)->first();
        }
        // $order_detials = DB::table('enrolls')
        //     ->where('transaction_id', $tran_id)
        //     ->select('transaction_id', 'status', 'currency', 'total')->first();

        if ($enroll_info->status == 'Pending') {
            $enroll_info->update(['status' => 'Failed']);
            echo "Transaction is Falied";
        } else if ($enroll_info->status == 'Processing' || $enroll_info->status == 'Complete') {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }
        Toastr::error('Transaction is Invalid!');
        return redirect('/');
    }

    public function payment_cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');

        // $order_detials = DB::table('enrolls')
        //     ->where('transaction_id', $tran_id)
        //     ->select('transaction_id', 'status', 'currency', 'total')->first();
        if ($enroll_info = Enroll::where('transaction_id', $tran_id)->first()) {
        } else {
            $enroll_info = LiveEnroll::where('transaction_id', $tran_id)->first();
        }
        if ($enroll_info->status == 'Pending') {
            $enroll_info->update(['status' => 'Canceled']);
            echo "Transaction is Cancel";
        } else if ($enroll_info->status == 'Processing' || $enroll_info->status == 'Complete') {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }
        Toastr::error('Transaction is Cancel!');
        return redirect('/');
    }

    public function payment_ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {

            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            // $order_details = DB::table('enrolls')
            //     ->where('transaction_id', $tran_id)
            //     ->select('transaction_id', 'status', 'currency', 'total')->first();
            if ($enroll_info = Enroll::where('transaction_id', $tran_id)->first()) {
            } else {
                $enroll_info = LiveEnroll::where('transaction_id', $tran_id)->first();
            }

            if ($enroll_info->status == 'Pending') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($tran_id, $enroll_info->total, $enroll_info->currency, $request->all());
                if ($validation == TRUE) {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successful transaction to customer
                    */
                    // $update_product = DB::table('enrolls')
                    //     ->where('transaction_id', $tran_id)
                    //     ->update(['status' => 'Complete']);
                    $enroll_info->update(['status' => 'Complete']);

                    echo "Transaction is successfully Completed";
                } else {
                    /*
                    That means IPN worked, but Transation validation failed.
                    Here you need to update order status as Failed in order table.
                    */
                    // $update_product = DB::table('enrolls')
                    //     ->where('transaction_id', $tran_id)
                    //     ->update(['status' => 'Failed']);
                    $enroll_info->update(['status' => 'Failed']);

                    echo "validation Fail";
                }
            } else if ($enroll_info->status == 'Processing' || $enroll_info->status == 'Complete') {

                #That means Order status already updated. No need to udate database.

                echo "Transaction is already successfully Completed";
            } else {
                #That means something wrong happened. You can redirect customer to your product page.

                echo "Invalid Transaction";
            }
        } else {
            echo "Invalid Data";
        }
    }

    public function payment_order(Request $request, $enroll_id)
    {
        $enroll = Enroll::find($enroll_id);
        if (!$enroll) {
            Toastr::error('Something wrong try again!');
            return redirect('/');
        }
        $post_data = array();
        $post_data['total_amount'] = $enroll->total; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = $enroll->transaction_id; // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Customer Name';
        $post_data['cus_email'] = 'customer@mail.com';
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '8801XXXXXXXXX';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
    }

    public function order_cancel(Request $request, $id)
    {
        $enroll = Enroll::find($id);
        if (!$enroll) {
            Toastr::error('Something wrong try again!');
            return redirect('/');
        }

        Enroll::where('id', $id)->update([
            'status' => 'Canceled'
        ]);
        Toastr::success('Your order canceled');
        return back();
    }
}
