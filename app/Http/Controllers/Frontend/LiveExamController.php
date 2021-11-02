<?php

namespace App\Http\Controllers\Frontend;

use App\Models\LiveEnroll;
use Carbon\Carbon;
use App\Models\MainMcq;
use App\Models\LiveExam;
use App\Models\McqAnswer;
use App\Models\McqManage;
use Illuminate\Http\Request;
use App\Models\LiveExamAnswer;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

class LiveExamController extends Controller
{
    public function ExamEventPage()
    {

        $exams = LiveExam::with('class')
            ->where('end_time', '>', Carbon::now())
            ->orderBy('start_time', 'asc')
            ->get();
        // return $exams;
        return view('frontend.live_exam.exam page', compact('exams'));
    }

    public function ExamPage($id)
    {
        $liveexam = LiveExam::findOrFail($id);
        //dd($liveexam->end_time->gt(now()));

        if ($liveexam->exam_type == 1) {
            $live_enroll = auth()->user()->live_enroll()->where('live_exam_id', $id)->first();
           if (!$live_enroll) {
            Toastr::error('First enroll this exam!');
            return back();
           }
        }
        $has_ans = LiveExamAnswer::where('main_mcq_id', $liveexam->main_mcq_id)
            ->where('user_id', auth()->id())
            ->get();

        if($liveexam->end_time->gt(now()) && $has_ans->count() > 0) {
            Toastr::error('Result not published yet!');
            return back();
        }

        if ($has_ans->count() > 0) {
            $main_mcq = MainMcq::where('id', $liveexam->main_mcq_id)->first();
            $ans_mcq =  McqAnswer::where('main_mcq_id', $liveexam->main_mcq_id)
                ->get();
            $user_ans = $has_ans;

            return view('frontend.live_exam.exam answer', compact('main_mcq', 'ans_mcq', 'user_ans'));
        }
        if ($liveexam->end_time < Carbon::now()) {
            Toastr::error('Exam Time Out Try Another!');
            return back();
        }
        $mcq = $liveexam->mcq;
        return view('frontend.live_exam.exam', compact('mcq', 'liveexam'));
    }

    public function ExamDetails($id)
    {
        $exam = LiveExam::with(['class', 'user', 'enroll' => function($query) {
            $query->where('status', '!=', 'Canceled');
        }])->find($id);
        $enrollCount = $exam->enroll->count();
        $isEnrolled  = $exam->enroll()->where('status', '!=', 'Canceled')
            ->where('user_id', auth()->id())
            ->exists();

        return view('frontend.live_exam.exam-details')->with([
            "exam"         => $exam,
            "enroll_count" => $enrollCount,
            "is_enrolled"  => $isEnrolled
        ]);
    }

    public function ExamSubmit(Request $request)
    {
        $mcq = McqAnswer::where('main_mcq_id', $request->mcq_id)
            ->where('sl', $request->mcq_sl)
            ->where('questions_type', '!=', 'only_paragraph_5')->get();
        if (count($mcq) <= 0) {
            Toastr::error('Something wrong try again!');
            return back();
        }
        $has_ans = LiveExamAnswer::where('main_mcq_id', $request->mcq_id)->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();

        if ($has_ans->count() > 0) {
            $liveExam = $has_ans->first()->liveExam()->first();
            if($liveExam->end_time->gt(now())) {
                Toastr::error('Result not published yet!');
                return redirect()->route('exam.details', ['id' => $liveExam->id]);
            }
            $main_mcq = MainMcq::where('id', $request->mcq_id)->where('sl', $request->mcq_sl)->first();
            $ans_mcq =  McqAnswer::where('main_mcq_id', $request->mcq_id)
                ->where('sl', $request->mcq_sl)
                ->get();
            $user_ans = LiveExamAnswer::where('main_mcq_id', $request->mcq_id)->where('user_id', auth()->id())->get();

            return view('frontend.live_exam.exam answer', compact('main_mcq', 'ans_mcq', 'user_ans'));
        }
        foreach ($mcq as $k =>  $mc) {
            foreach ($request->except(['_token', 'mcq_id', 'mcq_sl', 'live_exam_id']) as $ans_item_name => $item_ans) {
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
                            $mcq_ans = new LiveExamAnswer();
                            $mcq_ans->user_id = auth()->id();
                            $mcq_ans->main_mcq_id = $request->mcq_id;
                            $mcq_ans->sl = $request->mcq_sl;
                            $mcq_ans->question_id = $ans_item_name;
                            $mcq_ans->questions_type = $mc->questions_type;
                            $mcq_ans->answers = $item_ans;
                            $mcq_ans->correct_answers = $mc->answers;
                            $mcq_ans->points = $points;
                            $mcq_ans->live_Exam_id = $request->live_exam_id;
                            $mcq_ans->answer_review = $mc->answer_review;
                            $mcq_ans->save();
                        }
                    }
                }

            }
        }

        $main_mcq = MainMcq::where('id', $request->mcq_id)->where('sl', $request->mcq_sl)->first();
        $ans_mcq =  McqAnswer::where('main_mcq_id', $request->mcq_id)
            ->where('sl', $request->mcq_sl)
            ->get();
        $user_ans = LiveExamAnswer::where('main_mcq_id', $request->mcq_id)->where('user_id', auth()->id())->get();
        $liveExam = $user_ans->first()->liveExam()->first();
        if($liveExam->end_time->gt(now())) {
            Toastr::error('Result not published yet!');
            return redirect()->route('exam.details', ['id' => $liveExam->id]);
        }

        return view('frontend.live_exam.exam answer', compact('main_mcq', 'ans_mcq', 'user_ans'));
    }
}
