@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1 class="mb-4">Order Details - #{{ $order->id }}</h1>

        <h3>Customer Information</h3>
        <p><strong>Name:</strong> {{ $order->customer_name }}</p>
        <p><strong>Email:</strong> {{ $order->customer_email }}</p>
        <p><strong>Address:</strong> {{ $order->customer_address }}</p>
        <p><strong>Total Price:</strong> {{ number_format($order->total_price, 2) }}</p>

        <h3>Order Items</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price per Unit</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->price, 2) }}</td>
                        <td>{{ number_format($item->quantity * $item->price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary mt-4">Back to Orders</a>
    </div>
@endsection
