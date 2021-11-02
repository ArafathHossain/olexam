<?php

namespace App\Providers;

use App\Models\Footer;
use App\Models\StudentClass;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Laravel\Paddle\Cashier;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Cashier::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {

            $notifications = (object)[];
            if (Auth::check()) {
                $user = auth()->user();
                $notifications = $user->unreadNotifications;
            }
            $classes = StudentClass::orderBy('name', 'asc')->get();
            $footers_list  = Footer::all()->groupBy('column');
            $view->with([
                'classes' => $classes,
                'notifications' => $notifications,
                'footers_list' => $footers_list,
            ]);
        });
    }
}
