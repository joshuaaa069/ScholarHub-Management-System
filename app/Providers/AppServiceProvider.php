<?php

namespace App\Providers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Every student page (and the student sidebar partial itself) needs
        // an accurate unread-notifications count for its badge. Rather than
        // relying on each controller to remember to compute and pass it
        // (which is how it went stale/mock before), share it here from a
        // single source of truth.
        View::composer(['student.*', 'layouts.sidebar-student'], function ($view) {
            $count = 0;

            if (Auth::check() && Auth::user()->role === 'student') {
                $count = Notification::where('user_id', Auth::id())
                    ->where('is_read', false)
                    ->count();
            }

            $view->with('unreadNotificationsCount', $count);
        });
    }
}
