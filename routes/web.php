<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArtTypeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\RestrictAdminAccess;
use App\Http\Middleware\RestrictUserAccess;



Route::middlewareGroup('restrictAdmin', [
    RestrictAdminAccess::class,
]);

Route::middlewareGroup('restrictUser', [
    RestrictUserAccess::class,
]);


Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth', 'verified'])->group(function () {

    // Admin routes
    Route::get('/administrator', function () {
        if (auth()->user()->role !== 'admin') {
            abort(403); // or redirect to unauthorized page
        }
        return view('seller.seller_homepage');
    })->name('administrator');

    // User routes
    Route::get('/user', function () {
        if (auth()->user()->role !== 'user') {
            abort(403); // or redirect to unauthorized page
        }
        return view('customer.customer_homepage');
    })->name('user');

    Route::middleware('restrictAdmin')->group(function () {
        Route::get('/user', [UserController::class, 'index'])->name('user');        
        Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
        Route::get('/cart', [OrderController::class, 'viewCart'])->name('cart.view');
        Route::post('/cart/add/{product}', [OrderController::class, 'addToCart'])->name('cart.add');
        Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
        Route::delete('/cart/remove/{productId}', [OrderController::class, 'remove'])->name('cart.remove');

    
    });
    
    
    Route::middleware('restrictUser')->group(function () {
        
        Route::get('/art-types', [ArtTypeController::class, 'index'])->name('art_types.index');
        Route::get('/art-types/create', [ArtTypeController::class, 'create'])->name('art_types.create');
        Route::post('/art-types', [ArtTypeController::class, 'store'])->name('art_types.store');
        Route::put('/art-types/{artType}',  [ArtTypeController::class, 'update'])->name('art_types.update');
        Route::get('/art_types/{artType}/edit', [ArtTypeController::class, 'edit'])->name('art_types.edit');
        Route::delete('/art_types/{artType}', [ArtTypeController::class, 'destroy'])->name('art_types.destroy');

        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    });
    
    
});

require __DIR__.'/auth.php';



