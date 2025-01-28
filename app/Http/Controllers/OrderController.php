<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class OrderController extends Controller
{
    // Menampilkan daftar semua pesanan
    public function index()
    {
        $orders = Order::with('orderItems.product')->paginate(10); // Mengambil semua pesanan dengan relasi produk
        return view('admin.orders.index', compact('orders')); // Return ke view
    }

    // Menyimpan pesanan baru
    public function store(Request $request)
    {
        // Validasi data yang masuk
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'address' => 'required|string|max:500',
            'total_price' => 'required|numeric',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id', // Pastikan produk ada
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric',
        ]);

        // Buat pesanan baru
        $order = Order::create([
            'customer_name' => $validated['name'],
            'customer_email' => $validated['email'],
            'customer_address' => $validated['address'],
            'total_price' => $validated['total_price'],
        ]);

        // Loop produk dan buat item pesanan
        foreach ($validated['products'] as $productData) {
            $product = Product::find($productData['id']);

            // Periksa apakah stok mencukupi
            if ($product->stock < $productData['quantity']) {
                return redirect()->back()->withErrors('Stok tidak mencukupi untuk produk: ' . $product->name);
            }

            // Kurangi stok produk
            $product->decrement('stock', $productData['quantity']);

            // Buat item pesanan
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $productData['quantity'],
                'price' => $productData['price'],
            ]);
        }

        return redirect()->route('products.index')->with('success', 'Pesanan berhasil dibuat!');
    }

    // Menampilkan detail pesanan tertentu
    public function show(Order $order)
    {
        $order->load('orderItems.product'); // Muat relasi item pesanan dan produk
        return view('admin.orders.show', compact('order')); // Return ke view
    }

    // Menghapus pesanan
    public function destroy(Order $order)
    {
        // Kembalikan stok produk sebelum menghapus pesanan
        foreach ($order->orderItems as $item) {
            $product = $item->product;
            $product->increment('stock', $item->quantity); // Kembalikan stok
        }

        // Hapus pesanan
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Pesanan berhasil dihapus!');
    }
}
