<?php

namespace App\Http\Controllers;

use App\Models\Enroll;
use App\Models\Package;
use App\Models\StudentClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $currentYear = Carbon::now()->format('Y');
        $currentMonth = Carbon::now()->format('m');

        $todayRevenue = Enroll::whereDate('created_at', Carbon::today())
            ->where('package_type', 1)
            ->where('status', 'Complete')->sum('total');

        $currentMonthRevenue = Enroll::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->where('package_type', 1)
            ->where('status', 'Complete')->sum('total');

        $currentYearRevenue = Enroll::whereYear('created_at', $currentYear)
            ->where('package_type', 1)
            ->where('status', 'Complete')->sum('total');

        return view('admin.dashboard')->with([
            "today_revenue" => $todayRevenue,
            "current_month_revenue" => $currentMonthRevenue,
            "current_year_revenue" => $currentYearRevenue,
            "classes" => StudentClass::all(),
            "all_packages" => Package::with(['subject', 'class'])
                ->whereHas('class', function ($query) {
                    $query->when(\request()->get('class_id'), function ($query, $classId) {
                        return $query->whereId($classId);
                    });
                })
                ->withCount('enrolls')->orderBy('id', 'desc')->get()
        ]);
    }
}
