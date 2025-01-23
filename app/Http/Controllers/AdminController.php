<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Show the admin dashboard with statistics and lists for products, orders, and users
    public function index()
    {
        return view('admin.index', [
            'totalProducts' => Product::count(), // Hitung total produk
            'totalCategories' => Category::count(), // Hitung total kategori
            'totalOrders' => Order::count(), // Hitung total pesanan
            'totalUsers' => User::count(), // Hitung total pengguna
            'products' => Product::with('category')->get(), // Daftar produk dengan relasi kategori
            'orders' => Order::with('user')->get(), // Daftar pesanan dengan relasi pengguna
            'users' => User::all(), // Semua pengguna
            'categories' => Category::all(), // Semua kategori untuk akses di view
        ]);
    }

    // Show the form to create a new product
    public function create()
    {
        $categories = Category::all(); // Retrieve all categories
        return view('admin.products.create', compact('categories')); // Pass categories to the view
    }

    // Store a new product in the database
    public function store(Request $request)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id', // Ensure category exists
        ]);

        // Create the product
        Product::create($validated);

        // Redirect to the product index page with a success message
        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    // Show the form to edit an existing product
    public function edit(Product $product)
    {
        $categories = Category::all(); // Retrieve all categories
        return view('admin.products.edit', compact('product', 'categories')); // Pass product and categories to the view
    }

    // Update the existing product in the database
    public function update(Request $request, Product $product)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id', // Ensure category exists
        ]);

        // Update the product with validated data
        $product->update($validated);

        // Redirect to the product index page with a success message
        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    // Delete the specified product
    public function destroy(Product $product)
    {
        // Delete the product
        $product->delete();

        // Redirect to the product index page with a success message
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }
}
