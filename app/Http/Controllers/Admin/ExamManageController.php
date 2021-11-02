<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\McqManage;

class ExamManageController extends Controller
{
    public function index()
    {
        $exams = McqManage::with(['package', 'teacher'])
            ->orderBy('id', 'desc')
            ->get();
//        ddd($exams->toArray());
        return view('admin.manage-exam.index', compact('exams'));
    }

    public function get_exam($id)
    {

        $exam = McqManage::findOrFail($id);
        $users = User::permission('manage-exam')->get();
        return view('admin.manage-exam.edit', compact('users', 'exam'));
    }

    public function set_admin(Request $request, $id)
    {
        $request->validate([
            'admin_id' => 'required',
        ]);
        $exam  = McqManage::findOrFail($id);
        $exam->admin_id = $request->admin_id;
        $exam->set_admin = 1;
        $exam->save();

        return redirect()->route('admin.manage.exam')->with('success', 'Data is successfully saved');
    }
}
