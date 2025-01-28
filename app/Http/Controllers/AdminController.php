<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Constructor untuk memastikan hanya admin yang bisa mengakses
     */
    public function __construct()
    {
        $this->middleware('auth'); // Pastikan hanya user yang login
        $this->middleware('admin'); // Middleware khusus untuk admin (buat jika belum ada)
    }

    /**
     * Tampilkan halaman dashboard admin dengan data statistik
     */
    public function index()
{
    return view('admin.index', [
        'totalProducts' => Product::count(),
        'totalCategories' => Category::count(),
        'totalOrders' => Order::count(),
        'totalUsers' => User::count(),
        'products' => Product::all(), // Tambahkan variabel ini
        'orders' => Order::all(),     // Tambahkan variabel ini
        'categories' => Category::all(), // Tambahkan jika digunakan
        'users' => User::all(), // Tambahkan jika digunakan
    ]);
}

}
