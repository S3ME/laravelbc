<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\ProductCategories;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title          = 'Get Your Favorite Laptop Here | Gadget Store | Cheap Price Than Others';
        $request        = request();
        $search         = $request->input('search');
        $productsQuery  = Products::query();

        if ($search) {
            $productsQuery->where('name', 'like', '%' . $search . '%');
        }

        $products   = $productsQuery->with('category')->paginate(12)->withQueryString();

        return view('home', [
            'products'      => $products,
            'title'         => $title,
        ]);
    }

    /**
     * Display the Dashboard Backoffice.
     */
    public function dashboard()
    {
        $title              = 'Dashboard - GadgetStore';
        $totalProducts      = Products::count();
        $totalClicks        = Products::sum('click');
        $totalCategories    = ProductCategories::count();

        // Low stock alert (e.g. stock <= 5)
        $lowStockProducts   = Products::where('stock', '<=', 5)->get();

        // Stock Pie Chart Data
        $categories             = ProductCategories::with('products')->get();
        $categoryLabels         = [];
        $categoryStockCounts    = [];

        foreach ($categories as $category) {
            $categoryLabels[]       = $category->name;
            $categoryStockCounts[]  = $category->products->sum('stock');
        }

        return view('dashboard', compact(
            'totalProducts',
            'totalClicks',
            'totalCategories',
            'lowStockProducts',
            'categoryLabels',
            'categoryStockCounts'
        ));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Products::with('category')->findOrFail($id);
        
        $clickedKey = "product_clicked_{$id}";
        if (!session()->has($clickedKey)) {
            $product->increment('click');
            session()->put($clickedKey, true);
        }

        $relatedProducts = Products::where('product_categories_id', $product->product_categories_id)
            ->where('id', '!=', $product->id)
            ->orderBy('id', 'DESC')
            ->limit(4)
            ->get();

        return view('productdetail', compact('product', 'relatedProducts'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
