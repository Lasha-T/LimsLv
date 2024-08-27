@extends('layouts.shop')

@section('title', 'Products')

@section('content')
    <div class="container mx-auto p-4 flex justify-center">
        <div class="border p-4 rounded-lg shadow-lg w-72">
            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full object-cover mb-4">
            <div class="flex justify-between items-center mb-2">
                <h2 class="text-xl font-bold">{{ $product->name }}</h2>
                <p class="text-gray-700">{{ $product->description }}</p>
            </div>
            <div class="flex justify-between items-center mb-4">
                <p class="text-gray-700">${{ $product->price }}</p>
                <p class="text-gray-700">{{ $product->stock }} left</p>
            </div>
            <button class="bg-green-500 text-white px-4 py-2 rounded">Add to Cart</button>
        </div>
    </div>
@endsection
