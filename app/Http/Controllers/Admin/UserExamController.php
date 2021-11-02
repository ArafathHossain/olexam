<?php

namespace App\Http\Controllers\Admin;

use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MainMcq;
use App\Models\McqAnswer;
use App\Models\McqUserAnswer;
use Brian2694\Toastr\Facades\Toastr;

class UserExamController extends Controller
{
    public function uer_exam_view(Request $request, $user_id, $mcq_id)
    {
        $main_mcq = MainMcq::find($mcq_id);
        $ans_mcq = McqAnswer::where('main_mcq_id', $mcq_id)->get();
        $user_ans = McqUserAnswer::where('main_mcq_id', $mcq_id)
        ->where('user_id', $user_id)->get();
        if (!$main_mcq || !$user_ans) {
            Toastr::error('Something wrong try again!');
            return redirect()->back();
        }
        return view('admin.user-exam-submit.index', compact('main_mcq', 'ans_mcq', 'user_ans'));
    }
}
