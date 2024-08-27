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
        <div class="grid gap-4 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach($products as $product)
                <div class="border p-4 rounded-lg shadow-lg w-48 mx-auto">
                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-40 h-40 object-cover mb-2 mx-auto">
                    <h2 class="text-lg font-bold mb-1">{{ $product->name }}</h2>
                    <p class="text-gray-700 mb-2 text-sm">${{ $product->price }}</p>
                    <div class="flex justify-between">
                        <a href="" class="bg-blue-500 text-white px-3 py-1 rounded text-sm">View</a>
                        <button class="bg-green-500 text-white px-3 py-1 rounded text-sm">Add to Cart</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

