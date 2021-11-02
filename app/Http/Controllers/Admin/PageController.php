<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Melihovv\ShoppingCart\Facades\ShoppingCart as Cart;
class PageController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:manage-posts', ['only' => ['destroy']]);
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::orderBy('id', 'asc')->get();
        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.create');
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
            'title' => 'required|min:3|unique:pages,title',
            'content' => 'required',
        ]);
        $status = 0;
        if ($request->status) :
            $status = 1;
        endif;
        $page = new Page();
        $page->title = $request->title;
        $page->slug = Str::slug($request->title, '-');
        $page->content = $request->content;
        $page->status = $status;
        $page->save();
        return redirect()->route('admin.pages.index')->with('success', 'Data is successfully saved');
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
        $page = Page::findOrFail($id);
        return view('admin.pages.edit', compact('page'));
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
            'title' => 'required|min:3|unique:pages,title,' . $id,
            'content' => 'required',
        ]);
        $status = 0;
        if ($request->status) :
            $status = 1;
        endif;
        $page =  Page::findOrFail($id);
        $page->title = $request->title;
        $page->slug = Str::slug($request->title, '-');
        $page->content = $request->content;
        $page->status = $status;
        $page->save();
        return redirect()->route('admin.pages.index')->with('success', 'Data is successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $destroy = Page::findOrFail($id);
        $destroy->delete();
        return redirect()->route('admin.pages.index')->with('success', 'Data is successfully deleted');
    }
}
