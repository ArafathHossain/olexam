<?php

namespace App\Http\Controllers\Admin;

use App\Models\MainMcq;
use App\Models\Package;
use Illuminate\Support\Str;
use App\Models\StudentClass;
use Illuminate\Http\Request;
use App\Helper\PhotoUploadTrait;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\PackageExamNotification;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class PackageController extends Controller
{
    use PhotoUploadTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $all_packages = Package::with(['subject', 'class'])
            ->whereHas('class', function ($query) {
                $query->when(\request()->get('class_id'), function ($query, $classId) {
                    return $query->whereId($classId);
                });
            })
            ->orderBy('id', 'desc')->get();
        $classes = StudentClass::all();
        return view('admin.packages.index', compact('all_packages', 'classes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        $classes = StudentClass::orderBy('id', 'desc')->get();
        $mcqs = MainMcq::select('id', 'title', 'sl')->orderBy('id', 'desc')->get();
        if (!count($classes)) {
            return redirect()->route('admin.packages.index')->with('error', 'Create Class and Subject!');
        }
        if (!count($mcqs)) {
            return redirect()->route('admin.packages.index')->with('error', 'Create Mcq sets!');
        }
        return view('admin.packages.create', compact('classes', 'mcqs'));
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
            'class_id' => 'required',
            'package_type' => 'required',
            'description' => 'required',
            'photo' => 'required',
            'mcq_sets' => 'required',
        ], [
            'class_id.required' => 'Please select a class',
            'mcq_sets.required' => 'Please select a MCQ sets',
        ]);
        if ($request->package_type == 1) {
            $request->validate([
                'org_price' => 'required',
                'sale_price' => 'required',
            ]);
        }
        $package = new Package();
        $package->user_id = Auth::id();
        $package->class_id = $request->class_id;
        if($request->has('subject_id')) {
            $package->subject_id = $request->subject_id;
        }
        $package->title = $request->title;
        $package->slug = Str::slug($request->title);
        $package->package_type = $request->package_type;
        $package->free_mcq = $request->free_mcq ? implode(',', $request->free_mcq) : '';
        $package->org_price = $request->org_price;
        $package->sale_price = $request->sale_price;
        $package->description = $request->description;
        $package->skill_level = $request->skill_level;
        $package->mediam = $request->mediam;
        $package->features = $request->features ? implode('||', $request->features) : '';
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $request->validate([
                'photo' => 'max:2048|mimes:jpeg,jpg,png',
            ]);
            $photo_name = $this->UploadOne($photo, 'images/packages', [626, 417]);
            $package->photo = $photo_name;
        }
        // if ($request->hasFile('video')) {
        //     $video = $request->file('video');
        //     $request->validate([
        //         'video' => 'mimes:mp4,mov,ogg,qt|max:20000',
        //     ]);
        //     $video_name = $this->VideoUpload($video, 'videos/packages');
        //     $package->video = $video_name;
        // }
        $package->video = $request->video;
        $package->popular_package = $request->popular_package ? 1 : 0;
        $package->featured_package = $request->featured_package ? 1 : 0;
        $package->save();

        $package->mcqs()->attach($request->mcq_sets);

        $data = [
            'subject' => 'New package',
            'message' => 'Release a new package of your same class',
            'url' => url('/package/details/'.$package->id.'/'.$package->slug.''),
        ];
        $users = User::where('grad', $package->class_id)->get();
        Notification::send($users, new PackageExamNotification($data));
        return redirect()->route('admin.packages.index')->with('success', 'Package is successfully saved');
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
        $classes = StudentClass::orderBy('id', 'desc')->get();
        $mcqs = MainMcq::select('id', 'title')->orderBy('id', 'desc')->get();
        $package  = Package::find($id);
        return view('admin.packages.edit', compact('classes', 'mcqs', 'package'));
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
            'class_id' => 'required',
            'package_type' => 'required',
            'description' => 'required',
            'mcq_sets' => 'required',
        ], [
            'class_id.required' => 'Please select a class',
            'mcq_sets.required' => 'Please select a MCQ sets',
        ]);
        if ($request->package_type == 1) {
            $request->validate([
                'org_price' => 'required',
                'sale_price' => 'required',
            ]);
        }
        $package =  Package::find($id);
        $package->user_id = Auth::id();
        $package->class_id = $request->class_id;
        $package->subject_id = $request->subject_id;
        $package->title = $request->title;
        $package->slug = Str::slug($request->title);
        $package->package_type = $request->package_type;
        $package->free_mcq = $request->free_mcq ? implode(',', $request->free_mcq) : '';
        $package->org_price = $request->org_price;
        $package->sale_price = $request->sale_price;
        $package->description = $request->description;
        $package->skill_level = $request->skill_level;
        $package->mediam = $request->mediam;
        $package->features = $request->features ? implode('||', $request->features) : '';
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $request->validate([
                'photo' => 'max:2048|mimes:jpeg,jpg,png',
            ]);
            if ($package->photo != 'package.jpg') {
                $link = base_path('public/' . $package->photo);
                if (file_exists($link)) {
                    unlink($link);
                }
            }
            $photo_name = $this->UploadOne($photo, 'images/packages', [626, 417]);
            $package->photo = $photo_name;
        }
        $package->video = $request->video;
        $package->popular_package = $request->popular_package ? 1 : 0;
        $package->featured_package = $request->featured_package ? 1 : 0;

        // if ($request->hasFile('video')) {
        //     $video = $request->file('video');
        //     $request->validate([
        //         'video' => 'mimes:mp4,mov,ogg,qt|max:20000',
        //     ]);
        //     if ($package->video != 'video.mp4') {
        //         $link = base_path('public/' . $package->video);
        //         if (file_exists($link)) {
        //             unlink($link);
        //         }
        //     }
        //     $video_name = $this->VideoUpload($video, 'videos/packages');
        //     $package->video = $video_name;
        // }
        $package->save();

        $package->mcqs()->sync($request->mcq_sets);
        return redirect()->route('admin.packages.index')->with('success', 'Package is successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $destroy = Package::findOrFail($id);
        $destroy->delete();
        if ($destroy->photo != 'package.jpg') {
            $link = public_path('' . $destroy->photo);
            if (file_exists($link)) {
                unlink($link);
            }
        }
        $destroy->mcqs()->detach();
        return redirect()->route('admin.packages.index')->with('success', 'Package is successfully deleted');
    }

    public function ajax_subject(Request $request)
    {
        $class_id = $request->class_id;
        $options = '';
        if ($class_id) {
            $subjects = StudentClass::find($class_id)->subjects;
            foreach ($subjects as $subject) {
                // return $subject->id;
                $options .= '<option value="' . $subject->id . '">' . word_view($subject->name) . '</option>';
            }
            return $options;
        }
    }
}
