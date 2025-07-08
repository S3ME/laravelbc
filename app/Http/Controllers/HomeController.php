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
     * Order the Product.
     */
    public function order(Request $request, string $id)
    {
        $product    = Products::findOrFail($id);
        $validated  = $request->validate([
            'name'  => 'required|string|max:255',
            'phone' => 'required|numeric|digits_between:8,15',
            'qty'   => 'required|integer|min:1|max:' . $product->stock,
        ]);
        $customerName   = trim($validated['name']);
        $customerPhone  = '+62'.trim($validated['phone']);
        $quantity       = $validated['qty'];

        $text = "Hi, I'm {$customerName} ({$customerPhone}), I would like to order {$quantity} pcs of \"{$product->name}\".";
        $whatsappUrl = "https://api.whatsapp.com/send?phone=628xxx&text=" . urlencode($text);

        return redirect()->away($whatsappUrl);
    }

    /**
     * Add product to cart.
     */
    public function addToCart(Request $request, string $id)
    {
        $product    = Products::findOrFail($id);
        $qty        = (int) $request->input('qty', 1);

        if ($qty < 1) {
            $qty = 1;
        }
        if ($qty > $product->stock) {
            $qty = $product->stock;
        }

        $cart = session()->get('carts', []);
        if (isset($cart[$id])) {
            $cart[$id] += $qty;
            if ($cart[$id] > $product->stock) {
                $cart[$id] = $product->stock;
            }
        } else {
            $cart[$id] = $qty;
        }
        session()->put('carts', $cart);

        return redirect()->back()->with('success', "{$product->name} added to cart.");
    }

    /**
     * Showing Cart.
     */
    public function carts()
    {
        $cart = session()->get('carts', []);

        // Get product details for each item in the cart
        $cartItems = [];
        if (!empty($cart) && is_array($cart)) {
            foreach ($cart as $productId => $qty) {
                $product = Products::find($productId);
                if ($product) {
                    $cartItems[] = [
                        'product' => $product,
                        'qty' => $qty,
                    ];
                }
            }
        }

        return view('carts', [
            'cartItems' => $cartItems,
        ]);
    }

    /**
     * Update the quantity of a product in the cart.
     */
    public function updateCart(Request $request, $id)
    {
        $qty = (int) $request->input('qty', 1);
        $product = Products::findOrFail($id);

        if ($qty < 1) {
            $qty = 1;
        }

        if ($qty > $product->stock) {
            $qty = $product->stock;
        }

        $cart = session()->get('carts', []);
        if (isset($cart[$id])) {
            $cart[$id] = $qty;
        }

        session()->put('carts', $cart);

        return redirect()->back()->with('success', 'Cart updated.');
    }

    /**
     * Remove a product from the cart.
     */
    public function removeFromCart(string $id)
    {
        $cart = session()->get('carts', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('carts', $cart);
        }
        return redirect()->back()->with('success', 'Product removed from cart.');
    }

    /**
     * Checkout the cart.
     */
    public function checkout(Request $request)
    {
        $name  = $request->input('name');
        $phone = preg_replace('/[^0-9]/', '', $request->input('phone'));
        $cart  = session()->get('carts', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Cart is empty.');
        }

        $orderList = [];

        foreach ($cart as $productId => $qty) {
            $product = \App\Models\Products::find($productId);
            if ($product) {
                $orderList[] = "{$qty} pcs of \"{$product->name}\"";
            }
        }

        $orderText = implode(', ', $orderList);

        $message = "Hi, I'm {$name} ({$phone}), I would like to order {$orderText}.";

        $whatsappUrl = "https://api.whatsapp.com/send?phone=628xxx&text=" . urlencode($message);

        return redirect()->away($whatsappUrl);
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
