@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
    <h1 class="mb-4">Daftar Produk</h1>
    <div class="row">
        @foreach($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>
                        <p class="card-text"><strong>Rp{{ number_format($product->price) }}</strong></p>
                        <button class="btn btn-primary">Beli</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
