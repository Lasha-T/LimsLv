@extends('layouts.shop')

@section('title', 'Products')

@section('content')
<div class="flex">
    <aside class="w-1/4 p-4 bg-gray-100">
        <h2 class="text-xl font-bold mb-4">Categories</h2>
        <ul>
            <li><a href="#" class="block py-2">Category 1</a></li>
            <li><a href="#" class="block py-2">Category 2</a></li>
            <li><a href="#" class="block py-2">Category 3</a></li>
        </ul>
    </aside>
    <div class="flex-grow p-4">
        <h1 class="text-3xl font-bold mb-4">Our Products</h1>
        <div class="grid gap-4 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
            @foreach($products as $product)
            <div class="border p-4 rounded-lg shadow-lg w-44 mx-auto group">
                <a href="{{ route('shop.showProduct', $product->id) }}">
                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-32 h-32 object-cover mb-2 mx-auto">
                </a>
                <a href="{{ route('shop.showProduct', $product->id) }}">
                    <h2 class="text-lg font-bold mb-1">{{ $product->name }}</h2>
                </a>
                <div class="relative flex items-center justify-between mb-2">
                    <p class="text-gray-700 text-sm">${{ $product->price }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

