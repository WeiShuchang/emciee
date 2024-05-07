<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\OrderProduct;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Exception;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    //for viewing the cart
    public function create()
    {
        //
    }

   
    //adds to cart and store to database
    public function store(StoreOrderRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }

    public function viewCart() {
        $user = Auth::user();
        $cartOrders = Order::with('products')
                            ->where('user_id', $user->id)
                            ->where('status', 'cart')
                            ->latest()
                            ->get();

     
        $products = collect();
        foreach ($cartOrders as $order) {
            $products = $products->merge($order->products);
        }
        
        // Paginate the merged collection
        $perPage = 7;
        $currentPage = request()->get('page', 1);
        $paginatedProducts = new LengthAwarePaginator(
            $products->forPage($currentPage, $perPage),
            $products->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url()]
        );
    
        return view('customer.cart', compact('cartOrders', 'paginatedProducts'));
    }
    
        
    public function addToCart(Request $request, $productId)
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Retrieve the product by ID
        $product = Product::findOrFail($productId);

        // Retrieve the quantity from the form submission
        $quantity = $request->input('quantity');

        // Check if the user already has a cart order
        $cartOrder = $user->orders()->where('status', 'cart')->first();

        // If the user doesn't have a cart order, create one
        if (!$cartOrder) {
            $cartOrder = new Order();
            $cartOrder->user_id = $user->id;
            $cartOrder->status = 'cart';
            $cartOrder->save();
        }

        // Check if the product already exists in the cart
        $existingProduct = $cartOrder->products()->where('product_id', $productId)->first();

        // If the product already exists, throw an error
        if ($existingProduct) {
            return redirect()->back()->with('error', 'A product already exists in your cart. Please Clear or Checkout Before Ordering Again');
        }

        // Add the product to the cart order with the specified quantity
        $cartOrder->products()->attach($product->id, ['quantity' => $quantity]);

        // Redirect back to the product detail page or cart page
        return redirect()->back()->with('success', 'Product added to cart successfully.');
    }


        public function checkout()
        {
            try {
                // Update status of orders to "checked out"
                foreach (auth()->user()->orders as $order) {
                    $order->status = 'checked out';
                    $order->save();
                }
    
        
                // Add a success message
                session()->flash('success', 'Your order has been successfully placed.');
        
                // Redirect to a success page or do further processing
                return redirect()->route('cart.view');
            } catch (Exception $e) {
                // Handle any exceptions/errors that occur during the checkout process
                // You can log the error, display a generic error message, or redirect back with an error message
                return redirect()->back()->with('error', 'An error occurred during the checkout process. Please try again later.');
            }
        }

        

    public function remove($productId)
    {
        try {
            // Retrieve the authenticated user
            $user = Auth::user();

            // Retrieve the cart order of the user
            $cartOrder = $user->orders()->where('status', 'cart')->firstOrFail();

            // Detach the product from the cart order
            $cartOrder->products()->detach($productId);

            // Redirect back with success message
            return redirect()->back()->with('success', 'Product removed from cart successfully.');
        } catch (\Exception $e) {
            // Handle any exceptions/errors that occur during the removal process
            return redirect()->back()->with('error', 'An error occurred while removing the product from the cart.');
        }
    }

    
}
