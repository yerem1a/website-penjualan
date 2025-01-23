<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    public function store(Request $request)
{
    $order = Order::create([
        'customer_name' => $request->name,
        'customer_email' => $request->email,
        'customer_address' => $request->address,
        'total_price' => $request->total_price,
    ]);

    foreach ($request->products as $product) {
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product['id'],
            'quantity' => $product['quantity'],
            'price' => $product['price'],
        ]);
    }

    return redirect()->route('products.index')->with('success', 'Pesanan berhasil dibuat!');
}
}
