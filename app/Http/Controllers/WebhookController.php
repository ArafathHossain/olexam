<?php

namespace App\Http\Controllers;

use App\Models\LiveEnroll;
use Cart;
use App\Models\Enroll;
use Laravel\Paddle\Http\Controllers\WebhookController as CashierController;

class WebhookController extends CashierController
{

    public function handlePaymentSucceeded(array $payload)
    {
        $data = json_decode($payload['passthrough'], true);

        if($payload["alert_name"] === "payment_succeeded") {

            if($data['enrollment_type'] === 'package') {
                $enroll = new Enroll();
                $enroll->user_id = $data['billable_id'];
                $enroll->package_type = 1;
                $enroll->total = $payload['sale_gross'];
                $enroll->transaction_id = $payload['checkout_id'];
                $enroll->currency = $payload['currency'];
                $enroll->status = 'Complete';
                $enroll->save();
                $enroll->packages()->attach($data['package_ids']);
            }

            if($data['enrollment_type'] === 'live_exam') {
                $live_enroll = new LiveEnroll();
                $live_enroll->user_id = $data['billable_id'];
                $live_enroll->live_exam_id = $data['live_exam_id'];
                $live_enroll->total =$payload['sale_gross'];
                $live_enroll->status = 'Complete';
                $live_enroll->transaction_id = $payload['checkout_id'];
                $live_enroll->save();
            }

        }

        parent::handlePaymentSucceeded($payload);
    }
}
