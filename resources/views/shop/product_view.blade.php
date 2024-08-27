<!-- resources/views/shop/product_view.blade.php -->
@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <div class="container mx-auto p-4">
        <div class="border p-4 rounded-lg shadow-lg">
            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover mb-4">
            <h2 class="text-xl font-bold mb-2">{{ $product->name }}</h2>
            <p class="text-gray-700 mb-4">${{ $product->price }}</p>
            <p class="text-gray-700 mb-4">{{ $product->description }}</p>
            <button class="bg-green-500 text-white px-4 py-2 rounded">Add to Cart</button>
        </div>
    </div>
@endsection
