<?php

namespace App\Http\Controllers;

use App\Models\ArtType;
use App\Http\Requests\StoreArtTypeRequest;
use App\Http\Requests\UpdateArtTypeRequest;
use Illuminate\Database\QueryException;

use Illuminate\Http\Request;

class ArtTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all art types with pagination
        $artTypes = ArtType::paginate(5); 
        
        // Return the view with the paginated art types data
        return view('seller.arttype_list', compact('artTypes'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validate the request data
    $request->validate([
        'name' => 'required|string|max:255|unique:art_types,name',
    ], [
        'name.unique' => 'The art type name has already been taken.',
    ]);

    // Create a new art type instance
    $artType = new ArtType();
    $artType->name = $request->input('name');
    
    // Save the new art type to the database
    $artType->save();

    // Redirect back with success message
    return redirect()->back()->with('success', 'Art type added successfully.');
}

    /**
     * Display the specified resource.
     */
    public function show(ArtType $artType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ArtType $artType)
    {
        return view('seller.edit_arttype', compact('artType'));
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ArtType $artType)
{
    // Validate the incoming request data
    $validatedData = $request->validate([
        'name' => 'required|string|max:255|unique:art_types,name,' . $artType->id,
    ], [
        'name.unique' => 'The art type name has already been taken.',
    ]);

    // Update the art type with the validated data
    $artType->update($validatedData);

    // Redirect the user back to the index page with a success message
    return redirect()->route('art_types.index')->with('success', 'Art type updated successfully.');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ArtType $artType)
    {
        try {
            // Attempt to delete the art type
            $artType->delete();
            
            // If successful, redirect back with success message
            return redirect()->route('art_types.index')->with('success', 'Art type deleted successfully.');
        } catch (QueryException $e) {
            // Catch foreign key constraint violation
            if ($e->errorInfo[1] == 1451) {
                // If there is a foreign key constraint violation, display an error message
                return redirect()->back()->with('error', 'Cannot delete because products are currently associated with this art type.');
            } else {
                // For other database errors, you can handle them accordingly
                return redirect()->back()->with('error', 'An error occurred while deleting the art type.');
            }
        }
    }
}
