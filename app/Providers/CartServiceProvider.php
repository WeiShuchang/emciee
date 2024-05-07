<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Using a view composer to share data with views
        View::composer('*', function ($view) {
            // Check if the user is authenticated
            if (Auth::check()) {
                // Retrieve the number of products in the user's cart
                $cartCount = Order::where('user_id', Auth::id())
                    ->where('status', 'cart')
                    ->withCount('products')
                    ->value('products_count');

                // Pass the cart count to all views
                $view->with('cartCount', $cartCount);
            }
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
