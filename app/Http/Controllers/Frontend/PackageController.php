<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Review;
use App\Models\MainMcq;
use App\Models\Package;
use App\Models\McqAnswer;
use Illuminate\Http\Request;
use App\Models\McqUserAnswer;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\McqManage;
use App\Models\UserExamPoint;
use Brian2694\Toastr\Facades\Toastr;

class PackageController extends Controller
{
    public function create_review(Request $request)
    {
        // return $request->all();
        if (!auth()->user()) {
            Toastr::error('First, need to log in!');
            return back();
        }
        if (!Package::find($request->package_id)) {
            Toastr::error('Something wrong try again!');
            return back();
        }
        if (Review::where('package_id', $request->package_id)->where('user_id', auth()->id())->first()) {
            Toastr::warning('This package has already been reviewed!');
            return back();
        }
        $request->validate([
            'comment' => 'required',
            'rating' => 'required|numeric',
        ]);

        $review = new Review();
        $review->package_id = $request->package_id;
        $review->user_id = auth()->id();
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->save();

        Toastr::success('Review created successfully');
        return back();
    }

    public function all_reviews(Request $request)
    {
        $reviews = Review::where('package_id', 12)->paginate(4);
    }


    // fun for mcq exam
    public function get_mcq_exam(Request $request, $package_id, $mcq_id)
    {
        $package = Package::find($package_id);
        $mcq = MainMcq::find($mcq_id);
        $mcq_make = McqAnswer::where('main_mcq_id', $mcq_id)->get();
        if (!$package || !$mcq) {
            Toastr::error('Something wrong try again!');
            return redirect('/');
        }
        if ($request->nid_) {
            $notification = auth()->user()->notifications()->find($request->nid_);
            if ($notification) {
                $notification->markAsRead();
            }
        }
        $user_ans = McqUserAnswer::where('main_mcq_id', $mcq_id)->where('user_id', auth()->id())->get();
        if (count($user_ans) > 0) {
            $ans_mcq = McqAnswer::where('main_mcq_id', $mcq_id)->get();
            $main_mcq = $mcq;
            return view('frontend.mcq_ans_view', compact('main_mcq', 'ans_mcq', 'user_ans', 'package_id'));
        } else {
            if ($package->package_type == 0) {
                if (!$package->enrolls()->where('user_id', auth()->id())->exists()) {
                    Toastr::error('Enroll this package first!');
                    return back();
                } else {
                    return view('frontend.mcq_exam', compact('mcq', 'mcq_make', 'package_id'));
                }
            } else {
                $free_mcqs = explode(',', $package->free_mcq);
                if (in_array($mcq_id, $free_mcqs)) {
                    return view('frontend.mcq_exam', compact('mcq', 'mcq_make', 'package_id'));
                } else {
                    if (!$package->enrolls()->where('user_id', auth()->id())->exists()) {
                        Toastr::error('Enroll this package first!');
                        return back();
                    } elseif (!$package->enrolls()->where('status', 'Complete')->where('user_id', auth()->id())->exists()) {
                        Toastr::error('Transaction is not Completed!');
                        return back();
                    } else {
                        return view('frontend.mcq_exam', compact('mcq', 'mcq_make', 'package_id'));
                    }
                }
            }
        }
    }

    public function submit_mcq_exam(Request $request)
    {
        // return $request->all();
        $mcq = McqAnswer::where('main_mcq_id', $request->mcq_id)
            ->where('sl', $request->mcq_sl)
            ->where('questions_type', '!=', 'only_paragraph_5')->get();
        if (count($mcq) <= 0) {
            Toastr::error('Something wrong try again!');
            return back();
        }
        $has_ans = McqUserAnswer::where('main_mcq_id', $request->mcq_id)->where('user_id', auth()->id())->get();
        foreach ($mcq as $k =>  $mc) {
            foreach ($request->except(['_token', 'mcq_id', 'mcq_sl', 'package_id']) as $ans_item_name => $item_ans) {
                if ($mc->question_id == $ans_item_name) {
                    if (!is_array($item_ans)) {
                        if (count($has_ans) <= 0) {
                            $points = 0;
                            if ($mc->questions_type == 'shot_questions_1') {
                                if (in_array($item_ans, explode('||', $mc->answers))) {
                                    $points =  $mc->answer_points;
                                } else {
                                    $points = 0;
                                }
                            } else {
                                if (!empty($item_ans)) {
                                    if ($item_ans == $mc->answers) {
                                        $points =  $mc->answer_points;
                                    } else {
                                        $points = 0;
                                    }
                                } else {
                                    $points = 0;
                                }
                            }


                            $mcq_ans = new McqUserAnswer();
                            $mcq_ans->user_id = auth()->id();
                            $mcq_ans->main_mcq_id = $request->mcq_id;
                            $mcq_ans->sl = $request->mcq_sl;
                            $mcq_ans->question_id = $ans_item_name;
                            $mcq_ans->questions_type = $mc->questions_type;
                            $mcq_ans->answers = $item_ans;
                            $mcq_ans->correct_answers = $mc->answers;
                            $mcq_ans->points = $points;
                            $mcq_ans->package_id = $request->package_id;
                            $mcq_ans->answer_review = $mc->answer_review;
                            $mcq_ans->save();
                        }
                    }
                }
            }
        }
        // $data = [];
        // $data['user_id']  = $mcq_ans->user_id;
        // $data['mcq_id']  = $mcq_ans->user_id;
        $main_mcq = MainMcq::where('id', $request->mcq_id)->where('sl', $request->mcq_sl)->first();
        $ans_mcq =  McqAnswer::where('main_mcq_id', $request->mcq_id)
            ->where('sl', $request->mcq_sl)
            ->get();
        $user_ans = McqUserAnswer::where('main_mcq_id', $request->mcq_id)->where('user_id', auth()->id())->get();
        // $user_point = new UserExamPoint();
        // $user_point->user_id = auth()->id();
        // $user_point->main_mcq_id = $request->mcq_id;
        // $user_point->points = $user_ans->sum('points');
        // $user_point->save();

        $sl = McqManage::orderBy('serial_number', 'desc')->first();
        $seriial = 100;
        if ($sl->serial_number) {
            $seriial = ++$sl->serial_number;
        }
        $mcq_manage = new McqManage();
        $mcq_manage->serial_number  = $seriial;
        $mcq_manage->main_mcq_id  = $request->mcq_id;
        $mcq_manage->package_id  = $request->package_id;
        $mcq_manage->user_id  = auth()->id();
        $mcq_manage->points  = $user_ans->count('points');
        $mcq_manage->save();
        // return redirect()->route('mcq.exam', ['package_id' => $request->package_id, 'mcq_id' => $request->mcq_id]);
        return view('frontend.mcq_ans_view', compact('main_mcq', 'ans_mcq', 'user_ans'));
    }


    public function submit_mcq_exam_view(Request $request)
    {
        # code...
    }
}
