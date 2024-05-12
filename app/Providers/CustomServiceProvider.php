<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Order;
use Illuminate\Support\Facades\View;

class CustomServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('*', function ($view) {
            $user = auth()->user();

            $cancelledOrders = 0;
            if ($user) {
                $cancelledOrders = Order::where('user_id', $user->id)
                                        ->where('cancellled_notif', true)
                                        ->count();
            }

            $view->with('cancelledOrders', $cancelledOrders);
        });
    }

    public function register()
    {
        //
    }
}
