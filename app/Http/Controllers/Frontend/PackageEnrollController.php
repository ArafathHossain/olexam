<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Enroll;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;

class PackageEnrollController extends Controller
{
    public function free_package_enroll(Request $request)
    {
        $id = $request->id;
        $package = Package::find($id);
        if (!$package) {
            return back();
        }
        if ($package->enrolls()->where('user_id', auth()->id())->exists()) {
            return redirect()->route('all_courses');
        }
        $enroll = new Enroll();
        $enroll->user_id = auth()->id();
        $enroll->package_type = 0;
        $enroll->status = 'Complete';
        $enroll->save();
        $enroll->packages()->attach($package->id);
        Toastr::success('Thanks for choosing this package');

        // $packages = auth()->user()->enrolls;
        // return view('frontend.all_courses', compact('packages'));
        return redirect()->route('all_courses');
    }
}
