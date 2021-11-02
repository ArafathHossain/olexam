<?php

namespace App\Http\Controllers\Admin;

use App\Helper\PhotoUploadTrait;
use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{

    use PhotoUploadTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_data = About::all();
        return view('admin.abouts.index', compact('all_data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = About::count();
        if ($data > 0) {
            return back()->with('error', 'About Page already created, updata now');
        }
        return view('admin.abouts.create');
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
            'title' => 'required',
            'photo' => 'required|max:2048',
            'list_icon.*' => 'required',
            'list_title.*' => 'required',
            'list_content.*' => 'required',
        ]);

        $data = new About();
        $data->title = $request->title;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photo_name = $this->UploadOne($photo, 'images/about', []);
            $data->photo = $photo_name;
        }
        $data->list_icon = implode('||', $request->list_icon);
        $data->list_title = implode('||', $request->list_title);
        $data->list_content = implode('||', $request->list_content);
        $data->save();

        return redirect()->route('admin.abouts.index')->with('success', 'Data is successfully saved');
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
        $data = About::find($id);
        if (!$data) {
            return back();
        }
        return view('admin.abouts.edit', compact('data'));
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
            'title' => 'required',
            'photo' => 'sometimes|max:2048',
            'list_icon.*' => 'required',
            'list_title.*' => 'required',
            'list_content.*' => 'required',
        ]);

        $data =  About::findOrFail($id);
        $data->title = $request->title;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photo_name = $this->UploadOne($photo, 'images/about', [], '', $data->photo);
            $data->photo = $photo_name;
        }
        $data->list_icon = implode('||', $request->list_icon);
        $data->list_title = implode('||', $request->list_title);
        $data->list_content = implode('||', $request->list_content);
        $data->save();

        return redirect()->route('admin.abouts.index')->with('success', 'Data is successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $destroy = About::findOrFail($id);
        $destroy->delete();

        $link = public_path('' . $destroy->photo);
        if (file_exists($link)) {
            unlink($link);
        }

        return redirect()->route('admin.abouts.index')->with('success', 'Data is successfully deleted');
    }
}
