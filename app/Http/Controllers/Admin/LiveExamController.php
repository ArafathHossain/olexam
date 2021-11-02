<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\MainMcq;
use App\Models\LiveExam;
use Illuminate\Support\Str;
use App\Models\StudentClass;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PackageExamNotification;

class LiveExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_live_exams = LiveExam::orderBy('id', 'desc')->get();
        return view('admin.live-exams.index', compact('all_live_exams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mcqs = MainMcq::orderBy('id', 'desc')->get();
        $classes = StudentClass::orderBy('id', 'desc')->get();
        return view('admin.live-exams.create', compact('mcqs', 'classes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'title' => 'required',
                'start_time' => 'required',
                'end_time' => 'required',
                'exam_type' => 'required',
                'main_mcq_id' => 'required|integer',
                'student_class_id' => 'nullable|integer',
                'description' => 'nullable|string',
            ],
            ['main_mcq_id.required' => 'Please Select A MCQ!']
        );

        if ($request->exam_type == 1) {
            $request->validate([
                'price' => 'required'
            ]);
        }
        $start_time = Carbon::parse($request->start_time)->format('Y-m-d H:i:s');
        $end_time = Carbon::parse($request->end_time)->format('Y-m-d H:i:s');
        $live_exam = new LiveExam();
        $live_exam->user_id = auth()->id();
        $live_exam->main_mcq_id = $request->main_mcq_id;
        $live_exam->student_class_id = $request->student_class_id;
        $live_exam->title = $request->title;
        $live_exam->slug = Str::slug($request->title);
        $live_exam->start_time = $start_time;
        $live_exam->end_time = $end_time;
        $live_exam->exam_type = $request->exam_type;
        $live_exam->price = $request->price;
        $live_exam->description = $request->description;
        $live_exam->status = $request->status ? 1 : 0;
        $live_exam->save();

        $data = [
            'subject' => 'New Live Exam',
            'message' => 'Release a Live Exam of your same class',
            'url' => url('/live/exam#exam-'.$live_exam->id),
        ];
        if (!empty($request->student_class_id)) {
            $users = User::where('grad', $live_exam->student_class_id)->get();
            Notification::send($users, new PackageExamNotification($data));
        }
        return redirect()->route('admin.live-exams.index')->with('success', 'Data is successfully saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mcqs = MainMcq::orderBy('id', 'desc')->get();
        $classes = StudentClass::orderBy('id', 'desc')->get();
        $live_exam = LiveExam::findOrFail($id);

        return view('admin.live-exams.edit', compact('mcqs', 'live_exam', 'classes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'title' => 'required',
                'start_time' => 'required',
                'end_time' => 'required',
                'exam_type' => 'required',
                'main_mcq_id' => 'required|integer',
                'student_class_id' => 'nullable|integer',
                'description' => 'nullable|string',
            ],
            ['main_mcq_id.required' => 'Please Select A MCQ!']
        );
        if ($request->exam_type == 1) {
            $request->validate([
                'price' => 'required'
            ]);
        }
        $start_time = Carbon::parse($request->start_time)->format('Y-m-d H:i:s');
        $end_time = Carbon::parse($request->end_time)->format('Y-m-d H:i:s');
        $live_exam =  LiveExam::findOrFail($id);
        $live_exam->user_id = auth()->id();
        $live_exam->main_mcq_id = $request->main_mcq_id;
        $live_exam->student_class_id = $request->student_class_id;
        $live_exam->title = $request->title;
        $live_exam->slug = Str::slug($request->title);
        $live_exam->start_time = $start_time;
        $live_exam->end_time = $end_time;
        $live_exam->exam_type = $request->exam_type;
        $live_exam->price = $request->price;
        $live_exam->description = $request->description;
        $live_exam->status = $request->status ? 1 : 0;
        $live_exam->save();
        return redirect()->route('admin.live-exams.index')->with('success', 'Data is successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $destroy = LiveExam::findOrFail($id);
        $destroy->delete();
        return redirect()->route('admin.live-exams.index')->with('success', 'Data is successfully deleted');
    }
}
