<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Constructor untuk menambahkan middleware
    public function __construct()
    {
        $this->middleware('auth'); // Pastikan hanya user yang login
        $this->middleware('admin'); // Middleware khusus admin jika tersedia
    }

    // Menampilkan semua kategori dengan pagination
    public function index()
    {
        $categories = Category::paginate(10); // Pagination dengan 10 item per halaman
        return view('admin.categories.index', compact('categories'));
    }

    // Menampilkan form untuk membuat kategori baru
    public function create()
    {
        return view('admin.categories.create'); // Menampilkan form create
    }

    // Menyimpan kategori baru ke database
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name', // Nama kategori unik
        ]);

        // Buat kategori baru
        Category::create($validated);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully!');
    }

    // Menampilkan form untuk mengedit kategori
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category')); // Kirim data kategori ke form edit
    }

    // Memperbarui kategori di database
    public function update(Request $request, Category $category)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id, // Unik kecuali dirinya sendiri
        ]);

        // Perbarui kategori
        $category->update($validated);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully!');
    }

    // Menghapus kategori
    public function destroy(Category $category)
    {
        // Periksa apakah kategori digunakan di produk
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories.index')->withErrors('Cannot delete category because it is associated with products.');
        }

        // Hapus kategori
        $category->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully!');
    }
}
