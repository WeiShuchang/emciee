<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ArtType;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all products with pagination and eager load the arttype relationship
        $products = Product::with('arttype')->latest()->paginate(5);

        // Retrieve all art types
        $arttypes = ArtType::all();

        // Return the view with the paginated products data and art types
        return view('seller.product_list', compact('products', 'arttypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('customer.details', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255|unique:products,name',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:1',
            'arttype_id' => 'nullable|exists:art_types,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif', // Add validation for image field
        ], [
            'name.unique' => 'The product name has already been taken.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        } else {
            $imagePath = null;
        }

        // Create a new product instance
        $product = new Product();
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->stock = $request->input('stock');
        $product->price = $request->input('price');
        $product->arttype_id = $request->input('arttype_id');
        $product->image = $imagePath;

        // Save the new product to the database
        $product->save();

        // Redirect back with success message
        return redirect()->route('products.index')->with('success', 'Product added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $arttypes = ArtType::all();
        return view('seller.edit_product', compact('product','arttypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:products,name,' . $product->id,
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:1',
            'arttype_id' => 'nullable|exists:art_types,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif', // Add validation for image field
        ], [
            'name.unique' => 'The product name has already been taken.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validatedData['image'] = $imagePath;
        }

        // Update the product with the validated data
        $product->update($validatedData);

        // Redirect the user back to the index page with a success message
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            // Attempt to delete the product
            $product->delete();

            // If successful, redirect back with success message
            return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
        } catch (QueryException $e) {
            // Catch foreign key constraint violation
            if ($e->errorInfo[1] == 1451) {
                // If there is a foreign key constraint violation, display an error message
                return redirect()->back()->with('error', 'Cannot delete because orders are currently associated with this product.');
            } else {
                // For other database errors, you can handle them accordingly
                return redirect()->back()->with('error', 'An error occurred while deleting the product.');
            }
        }
    }
}
