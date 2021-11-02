<?php

namespace App\Http\Controllers\Admin;

use App\Models\McqManage;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeadBoardController extends Controller
{

    public function index(Request $request)
    {
        if ($request->p_ && !empty($request->p_)) {
            $package_ids= Package::where('title', 'like', '%' . $request->p_.'%')->pluck('id');
            $leadboards = McqManage::whereIn('package_id', $package_ids)->with(['user', 'package'])->orderBy('points', 'desc')->limit(12)->get();
        } else {
            $leadboards = McqManage::with(['user', 'package'])->orderBy('points', 'desc')->limit(12)->get();
        }
        return view('admin.leadboard.leadboard', compact('leadboards'));
    }
}
