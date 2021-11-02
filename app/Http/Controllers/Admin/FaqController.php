<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_data = Faq::orderBy('id', 'desc')->get()->groupBy('tab');
        return view('admin.faqs.index', compact('all_data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.faqs.create');
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
            'tab' => 'required',
            'title' => 'required',
            'content' => 'required',
        ]);
        $data = new Faq();
        $data->tab = $request->tab;
        $data->title = $request->title;
        $data->content = $request->content;
        $data->status = $request->status ? 1 : 0;
        $data->save();
        return redirect()->route('admin.faqs.index')->with('success', 'Data is successfully saved');
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
        $data = Faq::find($id);

        return view('admin.faqs.edit', compact('data'));
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
            'tab' => 'required',
            'title' => 'required',
            'content' => 'required',
        ]);
        $data = Faq::find($id);
        $data->tab = $request->tab;
        $data->title = $request->title;
        $data->content = $request->content;
        $data->status = $request->status ? 1 : 0;
        $data->save();
        return redirect()->route('admin.faqs.index')->with('success', 'Data is successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $destroy = Faq::findOrFail($id);
        $destroy->delete();

        return redirect()->route('admin.faqs.index')->with('success', 'Data is successfully deleted');
    }
}
