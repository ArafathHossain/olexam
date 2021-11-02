<?php

namespace App\Http\Controllers\Admin;

use App\Helper\PhotoUploadTrait;
use App\Models\Subject;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubjectController extends Controller
{
    use PhotoUploadTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_subjects = Subject::orderBy('id', 'desc')->get();
        return view('admin.subjects.index', compact('all_subjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.subjects.create');
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
            'name' => 'required|unique:subjects,name',
            'color' => 'required',
            'photo' => 'required',
        ], [
            'color.required' => 'Please select a color!'
        ]);
        $subject = new Subject();
        $subject->name = $request->name;
        $subject->color = $request->color;
        $subject->slug = Str::slug($request->name);
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $request->validate([
                'photo' => 'max:2048|mimes:jpeg,jpg,png',
            ]);
            $photo_name = $this->UploadOne($photo, 'images/subjects', [64, 64]);
            $subject->photo = $photo_name;
        }
        $subject->save();
        return redirect()->route('admin.subjects.index')->with('success', 'Subject is successfully saved');
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
        $subject = Subject::find($id);
        if ($subject) {
            return view('admin.subjects.edit', compact('subject'));
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
            'name' => 'required|unique:subjects,name,' . $id,
        ]);
        $subject =  Subject::find($id);
        $subject->name = $request->name;
        $subject->color = $request->color;
        $subject->slug = Str::slug($request->name);
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $request->validate([
                'photo' => 'max:2048|mimes:jpeg,jpg,png',
            ]);
            if ($subject->photo != 'images/content.png') {
                $link = public_path('' . $subject->photo);
                if (file_exists($link)) {
                    unlink($link);
                }
            }
            $photo_name = $this->UploadOne($photo, 'images/subjects', [64, 64]);
            $subject->photo = $photo_name;
        }
        $subject->save();
        return redirect()->route('admin.subjects.index')->with('success', 'Subject is successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $destroy = Subject::findOrFail($id);
        $destroy->delete();
        if ($destroy->photo != 'images/content.png') {
            $link = public_path('' . $destroy->photo);
            if (file_exists($link)) {
                unlink($link);
            }
        }
        return redirect()->route('admin.subjects.index')->with('success', 'Subject is successfully deleted');
    }
}
