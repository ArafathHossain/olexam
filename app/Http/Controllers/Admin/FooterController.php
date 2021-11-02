<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Footer;
use App\Models\Page;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $footers = Footer::orderBy('id', 'asc')
            ->get()
            ->groupBy('column');
        return view('admin.footers.index', compact('footers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pages = Page::orderBy('id', 'desc')->where('status', 1)->get();
        return view('admin.footers.create', compact('pages'));
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
            'column' => 'required',
            'title' => 'required',
            'name.*' => 'required',
            'link.*' => 'required',
        ]);
        $footer = Footer::where('column', $request->column)->first();
        if ($footer) {
            return redirect()->route('admin.footers.index')->with('error', 'The footer column already exists, please update');
        }
        $footer = new Footer();
        $footer->column = $request->column;
        $footer->title = $request->title;
        $footer->name = implode('||', $request->name);
        $footer->link = implode('||', $request->link);
        $footer->save();
        return redirect()->route('admin.footers.index')->with('success', 'Footer is successfully saved');
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
        $footer = Footer::find($id);
        if (!$footer) {
            return back();
        }
        $pages = Page::orderBy('id', 'desc')->where('status', 1)->get();
        return view('admin.footers.edit', compact('footer', 'pages'));
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
            'column' => 'required',
            'title' => 'required',
            'name.*' => 'required',
            'link.*' => 'required',
        ]);

        $footer =  Footer::find($id);
        $footer->column = $request->column;
        $footer->title = $request->title;
        $footer->name = implode('||', $request->name);
        $footer->link = implode('||', $request->link);
        $footer->save();
        return redirect()->route('admin.footers.index')->with('success', 'Footer is successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $destroy = Footer::findOrFail($id);
        $destroy->delete();
        return redirect()->route('admin.footers.index')->with('success', 'Footer is successfully deleted');
    }
}
