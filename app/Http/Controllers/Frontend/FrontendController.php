<?php

namespace App\Http\Controllers\Frontend;

use App\Models\LiveExam;
use Carbon\Carbon;
use Cart;
use App\Models\User;
use App\Models\Enroll;
use App\Models\Package;
use App\Models\StudentClass;
use Illuminate\Http\Request;
use App\Models\McqUserAnswer;
use App\Helper\PhotoUploadTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Faq;
use App\Models\McqManage;
use App\Models\Page;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller {

    use PhotoUploadTrait;


    public function index()
    {
        $featured_packages = Package::where('featured_package', 1)
            ->with('reviews', 'user')
            ->get();
        $popular_packages = Package::where('popular_package', 1)
            ->with(['class' => function ($query) {
                $query->pluck('name');
            }, 'reviews', 'user'])
            ->withCount('mcqs')->get();
        $subjects = null;

        if (Auth::check() && auth()->user()->grad !== '') {
            $subjects = StudentClass::find($class_id = auth()->user()->grad);
        }
        if (!$subjects) {
            $subjects = StudentClass::find($class_id = StudentClass::all()->random()->id);
        }

        $subjects = $subjects->subjects()->withCount('packages')->get();

        return view('frontend.index', compact('featured_packages', 'popular_packages', 'subjects', 'class_id'));
    }

    public function about()
    {
        $about = About::orderBy('id', 'desc')->first();

        return view('frontend.about', compact('about'));
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function faqs()
    {
        $faqs = Faq::orderBy('id', 'asc')->where('status', 1)->get()->groupBy('tab');

        return view('frontend.faqs', compact('faqs'));
    }

    public function package_free()
    {
        return view('frontend.package_free');
    }

    public function package(Request $request)
    {

        $cls = StudentClass::find($request->cls_);
        if (!$cls) {
            return redirect('/');
        }
        if (!$request->cls_ && empty($request->cls_)) {
            return back();
        } else {
            $sort = $request->sort_;
            $min = $request->min_;
            $max = $request->max_;
            $sub = $request->sub_;
            if ($sort) {
                if ($sort == 'all') {
                    $packages = Package::withCount('mcqs')->orderBy('id', 'desc')
                        ->where('class_id', $request->cls_);
                } elseif ($sort == 'free') {
                    $packages = Package::withCount('mcqs')->orderBy('id', 'desc')
                        ->where('package_type', 0)
                        ->where('class_id', $request->cls_);
                } elseif ($sort == 'premium') {
                    $packages = Package::withCount('mcqs')->orderBy('id', 'desc')
                        ->where('package_type', 1)
                        ->where('class_id', $request->cls_);
                } else {
                    return back();
                }
            } else {
                $packages = Package::withCount('mcqs')->orderBy('id', 'desc')
                    ->where('class_id', $request->cls_);
            }

            if (!empty($min) && !empty($max)) {
                $packages = $packages->where('sale_price', '>=', $min)
                    ->where('sale_price', '<=', $max);
            } else {
                $packages = $packages;
            }
            if (!empty($sub)) {
                $sub_ids = explode(',', $sub);
                $packages = $packages->whereIn('subject_id', $sub_ids);
            } else {
                $packages = $packages;
            }
            if ($request->q_) {
                $packages = $packages->where('title', 'like', '%' . $request->q_ . '%')
                    ->orWhere('description', 'like', '%' . $request->q_ . '%');
            }
            if ($request->term_) {
                $packages = $packages->where('title', 'like', '%' . $request->term_ . '%')
                    ->orWhere('description', 'like', '%' . $request->term_ . '%');
            }
        }
        $packages = $packages->paginate(10);
        $package_count = $packages->count();
        $classes = StudentClass::all();

        return view('frontend.package', compact('packages', 'classes', 'package_count'));
    }

    // load more package
    public function package_loadmore(Request $request)
    {
    }

    public function package_details($id, $title)
    {
        $package = Package::where('id', $id)
            ->where('slug', $title)->with([
                'class' => function ($query) {
                    $query->select('id', 'name');
                },
                'mcqs' => function ($query) {
                    $query->select('main_mcq_id as id', 'title', 'subject_id', 'optional');
                },
                'user' => function ($query) {
                    $query->select('id', 'name', 'photo');
                },
                'reviews'
            ])->withCount('enrolls', 'mcqs', 'reviews')->first();
        if (!$package) {
            return back();
        }
        $package->increment('view');

        return view('frontend.package_details', compact('package'));
    }

    public function classes($slug)
    {
        $class = StudentClass::where('slug', $slug)->with('subjects')->first();
        if (!$class) {
            return back();
        }

        return view('frontend.classes', compact('class'));
    }

    public function privacy()
    {
        return view('frontend.privacy');
    }

    public function error404()
    {
        return view('frontend.error404');
    }

    //Student Dashboard Methods

    public function student_dashboard()
    {
        return view('frontend.student_dashboard');
    }

    public function my_profile()
    {
        $user_submit_mcq = McqUserAnswer::where('user_id', auth()->id())->get();

        $auth = Auth::user()->id;
        $enrolls = DB::table('packages as p')
            ->join('enroll_package AS ep', 'p.id', '=', 'ep.package_id')
            ->join('enrolls AS r', 'ep.enroll_id', '=', 'r.id')
            ->join('mcq_user_answers AS mua', 'p.id', '!=', 'mua.package_id')
            ->where(function ($query) use ($auth) {
                $query->where('r.status', 'Complete')
                    ->where('r.user_id', $auth)
                    ->where('p.id', '!=', 'mua.package_id')// ->where('mua.user_id', '!=', $auth)
                ;
            })
            ->distinct('p.id')
            ->select('p.*')
            ->get();

        // $pending = ;
        return view('frontend.my_profile', compact('user_submit_mcq', 'enrolls'));
    }

    public function all_courses()
    {
        $enrolls = Enroll::orderBy('id', 'desc')->where('status', 'Complete')
            ->where('user_id', auth()->id())->get();

        return view('frontend.all_courses', compact('enrolls'));
    }

    public function course_stats()
    {
        $userId = \auth()->id();
        $packages = Package::whereHas('enrolls', function ($query) use ($userId) {
            $query->whereUserId($userId);
        })->with(['mcqs' => function ($query) use($userId) {
            $query->selectRaw('main_mcqs.id')
                ->withSum('mcq_answer', 'answer_points')
                ->withSum(['mcq_user_answer' => function ($query) use($userId) {
                    $query->whereUserId($userId);
                }], 'points');

        }])->get();

        $labels = $packages->pluck('title');
        $datasets  = $packages->reduce(function ($carry, $package) {
            if($package->mcqs->count()) {
                //$carry[0]['data'][] = $package->mcqs->sum('mcq_answer_sum_answer_points');
                $carry[0]['data'][] = ($package->mcqs->sum('mcq_user_answer_sum_points') / $package->mcqs->sum('mcq_answer_sum_answer_points')) * 100 ;
            } else {
                //$carry[0]['data'][] = 0;
                $carry[0]['data'][] = 0;
            }
            return $carry;
        }, [
            //['label' => 'Total Points', 'data' => [], 'fill' => false, 'borderColor' => '#da0b4e'],
            ['label' => "User's Points", 'data' => [], 'fill' => false, 'borderColor' => '#1865f2']
        ]);
        $max_y_scales = (int) max($datasets[0]['data']);

        return view('frontend.course_stats')->with(compact('labels', 'datasets', 'max_y_scales'));
    }

    public function live_exams()
    {
        $exams = LiveExam::with('class')
            ->whereHas('enroll', function ($query) {
                $query->whereUserId(\auth()->id());
            })
            ->orderBy('start_time', 'asc')
            ->get();

        return view('frontend.live_exam.dashboard_exam', compact('exams'));
    }

    public function my_orders()
    {
        $orders = Enroll::where('user_id', auth()->id())
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('frontend.my_orders', compact('orders'));
    }

    public function settings()
    {
        return view('frontend.settings');
    }

    public function saved_courses()
    {
        $my_wishlist = auth()->user()->my_wishlist;

        return view('frontend.saved_courses', compact('my_wishlist'));
    }

    public function add_to_cart()
    {
        if (Cart::isEmpty()) {
            return redirect('/');
        }
        $cart_items = Cart::getContent();

        return view('frontend.add_to_cart', compact('cart_items'));
    }

    public function product_wishlist()
    {
        return view('frontend.product_wishlist');
    }

    public function leadboard(Request $request)
    {
        if ($request->p_ && !empty($request->p_)) {
            $package_ids = Package::where('title', 'like', '%' . $request->p_ . '%')->pluck('id');
            $leadboards = McqManage::whereIn('package_id', $package_ids)->with(['user', 'package'])->orderBy('points', 'desc')->limit(12)->get();
        } else {
            $leadboards = McqManage::with(['user', 'package'])->orderBy('points', 'desc')->limit(12)->get();
        }

        return view('frontend.leadboard', compact('leadboards'));
    }

    // dynamic page
    public function page(Request $request, $slug)
    {
        $page = Page::where('slug', $slug)->where('status', 1)->first();
        if (!$page) {
            return back();
        }

        return view('frontend.page', compact('page'));
    }

    // user profile update
    public function user_update(Request $request, $id)
    {
        // return $request->all();
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|unique:users,phone,' . $id,
            'about' => 'nullable|string',
            'grad' => 'nullable|numeric',
        ]);
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->about = $request->about;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->zip = $request->zip;
        $user->grad = $request->grad;
        $user->favourite_subject = $request->favourite_subject;
        $user->github = $request->github;
        $user->linkedin = $request->linkedin;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $request->validate([
                'photo' => 'max:10240|mimes:jpeg,jpg,png',
            ]);
            if ($user->photo != 'images/user/user.png') {
                $link = base_path('public/' . $user->photo);
                if (file_exists($link)) {
                    unlink($link);
                }
            }
            $photo_name = $this->UploadOne($photo, 'images/user', [120, 120]);
            $user->photo = $photo_name;
        }
        $user->save();

        return redirect()->route('settings')->with('success', 'Your profile updated');
    }
}
