<?php

namespace App\Http\Controllers\Admin;

use App\Models\Package;
use App\Models\StudentClass;
use App\Models\User;
use App\Models\MainMcq;
use App\Models\McqAnswer;
use App\Models\McqManage;
use Illuminate\Http\Request;
use App\Models\McqUserAnswer;
use App\Http\Controllers\Controller;
use App\Notifications\UserExamNotification;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SendExamNotificationToUser;

class ResultManageController extends Controller
{
    public function index()
    {
        $all_exams = McqManage::with(['user', 'mcq'])->
        where('admin_id', auth()->id())
            ->where('set_answers', 0)
            ->orderBy('id', 'asc')->get();
        $classes = StudentClass::all();
        $packages = Package::whereHas('manage', function ($query) {
            $query->whereAdminId(auth()->id());
        })->get();

        //dd($packages->toArray());

        return view('admin.manage-result.index', compact('all_exams', 'classes', 'packages'));
    }

    public function get_exam($id)
    {
        $exam = McqManage::findOrFail($id);

        $main_mcq = MainMcq::find($exam->main_mcq_id);
        $ans_mcq =  McqAnswer::where('main_mcq_id', $exam->main_mcq_id)->get();
        $user_ans = McqUserAnswer::where('main_mcq_id', $exam->main_mcq_id)->where('user_id', $exam->user_id)->get();

        return view('admin.manage-result.edit', compact('main_mcq', 'ans_mcq', 'user_ans', 'exam'));
    }
    public function set_result(Request $request, $id)
    {
        $exam = McqManage::findOrFail($id);
        $points = 0;
        foreach ($request->except(['_token', 'exam_id']) as $key =>  $ans) {
            if ($user_ans = McqUserAnswer::find($key)) {
                $user_ans->points  = $ans;
                $user_ans->save();
            }
            $points += $ans;
        }
        $exam->update(['points' => $points, 'set_answers' => 1]);
        $data = [];
        $data['user_id'] = $exam->user_id;
        $data['admin_id'] = $exam->admin_id;
        $data['package_id'] = $exam->package_id;
        $data['main_mcq_id'] = $exam->main_mcq_id;
        $data['message'] = 'Your exam result publish';

        $user = User::find($exam->user_id);
        Notification::send($user, new SendExamNotificationToUser($data));
        return redirect()->route('admin.all.exam.set')->with('success', 'Exam review successfuly');
    }
}
