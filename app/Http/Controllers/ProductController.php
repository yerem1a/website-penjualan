<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Hanya pengguna yang login
        $this->middleware('admin'); // Middleware khusus admin, jika ada
    }

    // Display a listing of the products with pagination
    public function index()
    {
        $products = Product::with('category')->paginate(10); // Include category relation and paginate
        return view('admin.products.index', compact('products'));
    }

    // Show the form for creating a new product
    public function create()
    {
        $categories = Category::all(); // Retrieve all categories
        return view('admin.products.create', compact('categories'));
    }

    // Store a newly created product in storage
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        Product::create($validated); // Create new product

        return redirect()->route('admin.dashboard')->with('success', 'Product created successfully!');
    }

    // Display the specified product (optional)
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    // Show the form for editing the specified product
    public function edit(Product $product)
    {
        $categories = Category::all(); // Retrieve all categories
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // Update the specified product in storage
    public function update(Request $request, Product $product)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'category_id' => 'required|exists:categories,id',
    ]);

    $product->update($validated); // Update the product

    // Redirect ke admin.dashboard setelah berhasil update
    return redirect()->route('admin.dashboard')->with('success', 'Product updated successfully!');
}


    // Remove the specified product from storage
    public function destroy(Product $product)
    {
        $product->delete(); // Delete the product

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }
}
