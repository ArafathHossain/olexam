<?php

namespace App\Http\Controllers;

use Cart;
use Illuminate\Http\Request;

class PaymentSuccessController extends Controller
{
    public function __invoke()
    {
        Cart::clear();
        Cart::clearCartConditions();

        return redirect()->route('my_orders');
    }
}
