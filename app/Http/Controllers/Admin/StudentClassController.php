<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Models\StudentClass;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Subject;

class StudentClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_classes = StudentClass::orderBy('id', 'desc')->get();
        return view('admin.classes.index', compact('all_classes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subjects = Subject::orderBy('id', 'desc')->get();
        return view('admin.classes.create', compact('subjects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:student_classes,name',
            'subjects' => 'required',
        ]);
        $class = new StudentClass();
        $class->name = $request->name;
        $class->slug = Str::slug($request->name);
        $class->save();
        $class->subjects()->attach($request->subjects);
        return redirect()->route('admin.classes.index')->with('success', 'Class is successfully saved');
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
        $subjects = Subject::orderBy('id', 'desc')->get();
        $class = StudentClass::find($id);
        if ($class) {
            return view('admin.classes.edit', compact('class', 'subjects'));
        } else {
            return back();
        }
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
        $request->validate([
            'name' => 'required|unique:student_classes,name,' . $id,
            'subjects' => 'required',
        ]);
        $class =  StudentClass::find($id);
        $class->name = $request->name;
        $class->slug = Str::slug($request->name);
        $class->save();
        $class->subjects()->sync($request->subjects);
        return redirect()->route('admin.classes.index')->with('success', 'Class is successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $destroy = StudentClass::findOrFail($id);
        $destroy->delete();
        $destroy->subjects()->detach();
        return redirect()->route('admin.classes.index')->with('success', 'Class is successfully deleted');
    }
}
