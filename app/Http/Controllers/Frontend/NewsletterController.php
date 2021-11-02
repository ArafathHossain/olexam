<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Newsletter;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required'
        ]);


        if (!Newsletter::isSubscribed($request->email)) {
            Newsletter::subscribe($request->email);
            Toastr::success('Thanks for subscribed');
            return back();
        } else{
            Toastr::error('Your already subscribed');
            return back();
        }
    }
}
