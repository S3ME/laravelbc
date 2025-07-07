<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategories;

class ProductCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all categories from the database
        $categories = ProductCategories::orderBy('id', 'asc')->paginate(20);

        // Return the view with products and categories
        return view('category.index', [
            'categories'    => $categories,
            'title'         => 'Category List',
            'description'   => 'Browse our collection of categories.',
        ]);
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
        // Validating Data
        $request->validate([
            'name'          => 'required|string|max:255',
        ]);

        // Checking Unique Name & Processing Data
        $uniquename = ProductCategories::where('name', $request->name)->exists();
        if ($uniquename) {
            return redirect()->back()->with('errors','Category Name already exists');
        } else {
            $category           = new ProductCategories();
            $category->name     = $request->name;
            $category->save();

            return redirect()->route('categories')->with('success', 'Category created successfully!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Getting Category ID
        $category   = ProductCategories::findOrFail($id);

        // Validating Data
        $request->validate([
            'name'  =>  'required|string|max:255',
        ]);

        // Checking Unique Name & Processing Data
        $uniquename = ProductCategories::where('name', $request->name)->exists();
        if ($uniquename) {
            return redirect()->back()->with('errors','Category Name already exists');
        } else {
            $category->update([
                'name'  => $request->name,
            ]);
            return redirect()->route('categories')->with('success', 'Category updated successfully!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the product by ID
        $category = ProductCategories::findOrFail($id);

        // Delete the product from the database
        $category->delete();

        // Redirect to the product index with a success message
        return redirect()->route('categories')->with('success', 'Category deleted successfully!');
    }
}
