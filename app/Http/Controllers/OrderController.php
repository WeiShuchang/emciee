<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade as PDF;

use App\Models\Order;
use App\Models\Product;
use App\Models\ArtType;
use App\Models\User;
use Dompdf\Dompdf;
use Dompdf\Options;



use Illuminate\Support\Facades\DB;
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

    //view cart
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
    
        // Check if the quantity is valid
        if ($quantity <= 0) {
            return redirect()->back()->with('error', 'Quantity should be greater than 0.');
        }
    
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
    

    //checkout the cart
        public function checkout(Request $request)
        {
            try {
                // Update status of orders to "checked out"
                foreach (auth()->user()->orders as $order) {
                    $order->status = 'checked out';
                  
                }

                $order->fb_name = $request->fb_name;
                $order->phone_number = $request->phone_number;
                $order->save();
    
        
                // Add a success message
                session()->flash('success', 'Your order has been successfully placed.');
        
                // Redirect to a success page or do further processing
                return redirect()->route('user.orders');
            } catch (Exception $e) {
                // Handle any exceptions/errors that occur during the checkout process
                // You can log the error, display a generic error message, or redirect back with an error message
                return redirect()->back()->with('error', 'An error occurred during the checkout process. Please try again later.');
            }
        }

        
        //remove the items in the cart
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
    
    public function showShop()
    {
        $products = Product::paginate(4); // Paginate with 10 products per page, you can adjust this number as needed
        $arttypes = ArtType::all();
        return view('customer.shop', compact('products', 'arttypes'));
    }
    
    //JOIN TABLES: name, art type
    public function search(Request $request)
    {
        $search = $request->input('search');
        $arttypeId = $request->input('arttype'); 
    
        // Query to search by product name and join with art types table
        $query = Product::query()
            ->leftJoin('art_types', 'products.arttype_id', '=', 'art_types.id')
            ->select('products.*', 'art_types.name as art_type_name');
    
        if ($search) {
            // Search by product name or art type name
            $query->where(function($query) use ($search) {
                $query->where('products.name', 'like', '%' . $search . '%')
                      ->orWhere('art_types.name', 'like', '%' . $search . '%');
            });
        }
    
        // Query to filter by art type
        if ($arttypeId) {
            $query->where('products.arttype_id', $arttypeId);
        }
    
        // Execute the query and paginate the results
        $products = $query->paginate(4);
    
        // Retrieve all art types for the dropdown menu
        $arttypes = ArtType::all();
    
        return view('customer.shop', compact('products', 'arttypes'));
    }
    
    public function viewCheckedOutAdmin()
    {
        $orders = Order::where('status', 'checked out')
            ->where('is_delivered', false)
            ->where('is_shipped', false)
            ->where('cancelled', false)
            ->latest()
            ->get();
        
        return view('seller.checked_out_admin', compact('orders'));
    }


    public function viewCheckedOutDetails(Order $order)
{
    // Load the order details including associated products
    $order->load('user', 'products');

    // Pass the order data to the view for display
    return view('seller.checked_out_details', ['order' => $order]);
}


public function showUserOrders()
{
    // Get the current authenticated user
    $user = auth()->user();

    // Fetch orders associated with the current user
    $userOrders = Order::where('user_id', $user->id)
                        ->where('status', 'checked out')
                        ->where('cancelled', 'false')
                        ->latest()
                        ->paginate(8); // Adjust the pagination as per your requirement

    $totalPrice = 0;
                        
    return view('customer.customer_orders', compact('userOrders', 'totalPrice'));
}


public function cancel_user(Request $request, $order_id) {
    // Retrieve the order
 
    $order = Order::find($order_id);

    // Check if the order exists
    if (!$order) {
        // Handle case where order does not exist
        return response()->json(['error' => 'Order not found'], 404);
    }

    // Validate the request
    $request->validate([
        'reason_for_cancelling' => 'required|string|max:255', // Add any validation rules you need
    ]);

    // Update order fields
    $order->reason_for_cancelling = $request->input('reason_for_cancelling');
    $order->cancelled = true;

    // Save the changes
    $order->save();

    // Return a response
    return redirect()->route('user.orders')->with('success', 'Order Cancelled Successfully');


}

    public function showCancelView($order_id)
    {
        $order = Order::with('products')->with('user')->findOrFail($order_id);
        return view('customer.cancel_form', compact('order'));
    }

    public function cancel_admin(Request $request, $order_id) {
        // Retrieve the order
        $order = Order::find($order_id);

        // Check if the order exists
        if (!$order) {
            // Handle case where order does not exist
            return response()->json(['error' => 'Order not found'], 404);
        }

        // Validate the request
        $request->validate([
            'reason_for_cancelling' => 'required|string|max:255', // Add any validation rules you need
        ]);

        // Update order fields
        $order->reason_for_cancelling = $request->input('reason_for_cancelling');
        $order->cancelled = true;
        $order->cancellled_notif = true; // Set cancelled_notif to true

        // Save the changes
        $order->save();

        // Return a response
        return redirect()->route('view_checkedout_admin')->with('success', 'Order Cancelled Successfully');
    }


    public function showCancelViewAdmin($order_id)
    {
        $order = Order::with('products')->with('user')->findOrFail($order_id);
        return view('seller.cancel_form_admin', compact('order'));
    }

    public function hideNotif()
    {
        // Update notify_cancel to 0 for all orders belonging to the current user
        $user = Auth::user();
        $user->orders()->update(['cancellled_notif' => 0]);
    
        $userOrders = Order::with('products') 
        ->where('user_id', $user->id)
        ->where('cancelled', true)
        ->latest()
        ->paginate(10);
    
        return view('customer.cancelled_orders', compact('userOrders'));
    }
    
    public function viewCancelled(){
        // Update notify_cancel to 0 for all orders belonging to the current user
        $user = Auth::user();
    
        $userOrders = Order::with('products') // Eager load the flower relationship
                    ->where('user_id', $user->id)
                    ->where(function($query) {
                        $query->where('cancelled', true)
                              ;
                    })
                    ->latest()
                    ->paginate(10);
    
        return view('customer.cancelled_orders', compact('userOrders'));
    }


 
public function ship($order_id) {
    $order = Order::with('products')->find($order_id);

    if ($order) {
        // Check if the order is already shipped
        if ($order->is_shipped) {
            return redirect()->back()->with('error', 'Order has already been shipped.');
        }

        // Deduct product quantities from stocks
        foreach ($order->products as $product) {
            $orderProduct = $order->products()->where('product_id', $product->id)->first();
            $product->stock -= $orderProduct->pivot->quantity; // Deduct quantity from stock
            $product->save();
        }

        // Mark order as shipped
        $order->is_shipped = true;
        $order->save();

        return redirect()->back()->with('success', 'Order has been shipped successfully.');
    } else {
        return redirect()->back()->with('error', 'Order not found.');
    }
}

    public function shippedProducts()
    {
        $shippedProducts = Order::where('is_shipped', true)
            ->where('cancelled', false)
            ->where('is_delivered', false)
            ->where('status', 'checked out')
            ->with('products')
            ->get();

        return view('seller.shipped_products', compact('shippedProducts'));
    }

    public function markDelivered($order_id)
{
    $order = Order::find($order_id);

    if ($order) {
        $order->is_delivered = true;
        $order->cancelled = false;
        $order->is_shipped = false;
        $order->save();

        return redirect()->back()->with('success', 'Order has been marked as delivered.');
    } else {
        return redirect()->back()->with('error', 'Order not found.');
    }
}

   

    public function cancelledAdmin()
    {
        // Fetch all cancelled orders
        $cancelledProducts = Order::where('cancelled', true)->where('is_delivered', false)->get();
    
        return view('seller.cancelled_orders', compact('cancelledProducts'));
    }

        public function rateOrderView($order_id)
    {
        $order = Order::findOrFail($order_id);
        return view('customer.rate_order', compact('order'));
    }

    public function rateOrder(Request $request, $order_id)
    {
    
        $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
        ]);

        $order = Order::findOrFail($order_id);
        $order->rating = $request->rating;
        $order->save();

       
        return redirect()->route('user.orders')->with('success', 'Order rated successfully.');
    }





    
    //for searching - joined tables
    public function searchDeliveredOrders(Request $request)
    {
        // Retrieve search query
        $productId = $request->input('product');
        $userId = $request->input('user');
    
        // Retrieve products and users for dropdowns
        $products = Product::all();
        $users = User::where('role', '!=', 'admin')->get();
    
        // Perform search query with joined tables
        $deliveredProductsQuery = Order::where('is_delivered', true)
            ->where('cancelled', false)
            ->leftJoin('order_product', 'orders.id', '=', 'order_product.order_id')
            ->select('orders.*');
    
        // Join products table
        $deliveredProductsQuery->leftJoin('products', 'order_product.product_id', '=', 'products.id');
    
        // Filter by product if selected
        if ($productId) {
            $deliveredProductsQuery->where('order_product.product_id', $productId);
        }
    
        // Filter by user if selected
        if ($userId) {
            $deliveredProductsQuery->where('orders.user_id', $userId);
        }
    
        // Paginate the results
        $deliveredProducts = $deliveredProductsQuery->latest('orders.created_at')->paginate(5);
    
        return view('seller.delivered_orders', compact('deliveredProducts', 'products', 'users'));
    }
    
    //for showing delivered orders
    public function deliveredOrders()
    {
        // Fetch all delivered orders with joined tables
        $deliveredProducts = Order::where('is_delivered', true)
            ->where('cancelled', false)
            ->leftJoin('order_product', 'orders.id', '=', 'order_product.order_id')
            ->select('orders.*')
            ->leftJoin('products', 'order_product.product_id', '=', 'products.id')
            ->latest('orders.created_at')
            ->paginate(5);
    
    
        $products = Product::all();
        $users = User::where('role', '!=', 'admin')->get();
    
        return view('seller.delivered_orders', compact('deliveredProducts', 'products', 'users'));
    }
    
    
    //for exporting pdf
    public function exportToPDF(Request $request)
    {
       
        $productId = $request->input('product');
        $userId = $request->input('user');
    
      
        $products = Product::all();
        $users = User::where('role', '!=', 'admin')->get();
    
        // Perform search query with joined tables
        $deliveredProductsQuery = Order::where('is_delivered', true)
            ->where('cancelled', false)
            ->leftJoin('order_product', 'orders.id', '=', 'order_product.order_id')
            ->select('orders.*');
    
        // Join products table
        $deliveredProductsQuery->leftJoin('products', 'order_product.product_id', '=', 'products.id');
    
        // Filter by product if selected
        if ($productId) {
            $deliveredProductsQuery->where('order_product.product_id', $productId);
        }
    
        // Filter by user if selected
        if ($userId) {
            $deliveredProductsQuery->where('orders.user_id', $userId);
        }
    
        // Fetch filtered delivered orders
        $deliveredProducts = $deliveredProductsQuery->get(); // Use get() to retrieve all records
    
        // Load the view with data
        $view = view('seller.delivered_orders_pdf', compact('deliveredProducts', 'products', 'users'))->render();
    
        // Instantiate Dompdf with options
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $dompdf = new Dompdf($options);
    
        // Load HTML content
        $dompdf->loadHtml($view);
    
        // (Optional) Set paper size and orientation to portrait
        $dompdf->setPaper('A4', 'portrait');
    
        // Render PDF (optional)
        $dompdf->render();
    
        $bannerPath = public_path('img/banner-1.jpg');
    
        $imageWidth = 500;
        $imageHeight = 300; // Adjust according to the actual height of your image
    
        // Calculate the coordinates for the top center
        $leftLogoX = ($dompdf->getCanvas()->get_width() - $imageWidth) / 2;
        $leftLogoY = 400; // Adjust the Y coordinate if needed
    
        // Add the images to the PDF
        $dompdf->getCanvas()->image($bannerPath, $leftLogoX, $leftLogoY, $imageWidth, $imageHeight);
    
        // Output the generated PDF
        return $dompdf->stream('delivered_orders.pdf');
    }
    

}