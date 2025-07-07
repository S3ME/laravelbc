<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Products;
use App\Models\ProductCategories;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all products and categories from the database
        $products   = Products::with('category')->paginate(12);

        // Return the view with products and categories
        return view('product.index', [
            'products'      => $products,
            'title'         => 'Product List',
            'description'   => 'Browse our collection of products.',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ProductCategories::all();
        return view('product.create', [
            'categories'    => $categories,
            'title'         => 'Add New Product',
            'description'   => 'Insert a new product into the catalog.',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validating Data
        $validated = $request->validate([
            'name'          => 'required|string|max:255|unique:products,name',
            'description'   => 'nullable|string',
            'price'         => 'required|numeric|min:0',
            'category_id'   => 'required|exists:product_categories,id',
            'stock'         => 'nullable|integer|min:0',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Image Handler
        if ($request->hasFile('image')) {
            $photo     = $request->file('image');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photo->storeAs('images/products', $photoName, 'public');
        }

        // Processing Data
        $product                        = new Products();
        $product->name                  = $validated['name'];
        $product->description           = $validated['description'] ?? null;
        $product->price                 = $validated['price'];
        $product->product_categories_id = $validated['category_id'];
        $product->stock                 = $validated['stock'] ?? 0;
        $product->image                 = $photoName;
        $product->save();

        return redirect()->route('products')->with('success', 'Product created successfully!');
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
        $product    = Products::findOrFail($id);
        $categories = ProductCategories::all();
        return view('product.edit', [
            'product'       => $product,
            'categories'    => $categories,
            'title'         => 'Edit Product',
            'description'   => 'Modify the details of the selected product.',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Getting Product ID
        $product = Products::findOrFail($id);

        // Validating Data
        $validated = $request->validate([
            'name'          => 'required|string|max:255|unique:products,name',
            'description'   => 'nullable|string',
            'price'         => 'required|numeric|min:0',
            'category_id'   => 'required|exists:product_categories,id',
            'stock'         => 'nullable|integer|min:0',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Image Handler
        if ($request->hasFile('image')) {
            // Remove image if not null
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $photo          = $request->file('image');
            $photoName      = time() . '_' . $photo->getClientOriginalName();
            $photo->storeAs('images/products', $photoName, 'public');
        } else {
            $photoName      = $product->image;
        }

        // Saving Data
        $product->update([
            'name'                  => $validated['name'],
            'description'           => $validated['description'] ?? null,
            'price'                 => $validated['price'],
            'product_categories_id' => $validated['category_id'],
            'stock'                 => $validated['stock'] ?? 0,
            'image'                 => $photoName,
        ]);

        return redirect()->route('products')->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the product by ID
        $product = Products::findOrFail($id);

        // Delete the product's photo if it exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // Delete the product from the database
        $product->delete();

        // Redirect to the product index with a success message
        return redirect()->route('products')->with('success', 'Product deleted successfully!');
    }
}
