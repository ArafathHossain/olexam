<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactMailSend;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Mail;

class AllMailController extends Controller
{
    public function contact_mail_send(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);
        $data = [];
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['subject'] = $request->subject;
        $data['message'] = $request->message;

        Mail::to(env('ADMIN_MAIL', 'site@admin.com'))->queue(new ContactMailSend($data));

        Toastr::success('Thanks for contact us');
        return back();
    }
}
