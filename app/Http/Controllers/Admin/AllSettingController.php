<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomePage;
use App\Models\Setting;
use Illuminate\Http\Request;

class AllSettingController extends Controller
{
    public function get_setting()
    {
        return view('admin.all-setting.setting');
    }

    public function update_setting(Request $request)
    {
        Setting::setMany($request->except(['_token', 'method']));
        return redirect()->route('admin.get.setting')->with('success', 'Data saved successfully!');
    }
    public function get_home()
    {
        return view('admin.all-setting.home');
    }

    public function update_home(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);
        HomePage::setMany($request->except(['_token', 'method']));
        return redirect()->route('admin.get.home_page')->with('success', 'Data saved successfully!');
    }
}
