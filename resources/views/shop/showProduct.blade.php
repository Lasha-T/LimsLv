@extends('layouts.shop')

@section('title', 'Products')

@section('content')
    <div class="container mx-auto p-4 flex justify-center">
        <div class="border p-4 rounded-lg shadow-lg w-96">
            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full object-cover mb-4">
            <div class="flex justify-between items-center mb-2">
                <h2 class="text-xl font-bold">{{ $product->name }}</h2>
                <p class="text-gray-700">{{ $product->description }}</p>
            </div>
            <div class="flex justify-between items-center mb-4">
                <p class="text-gray-700">${{ $product->price }}</p>
                <p class="text-gray-700">{{ $product->stock }} left</p>
            </div>          
            <div class="flex justify-end">
                <form action="{{ route('shop.cart.add', $product->id) }}" method="POST" class="flex justify-end items-center">
                    @csrf
                    <input type="number" id="numberInput" name="quantity" value="1" min="1" class="w-12 h-8 text-left p-1 border border-green-500 rounded mr-2">                        
                    <button type="submit" class="bg-green-500 text-white px-4 py-1 rounded flex items-center">
                        Add to Cart
                        <svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="w-5 h-5 ml-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                        </svg> 
                    </button>
                </form>       
            </div>

        </div>
    </div>
    <script>
        let maxValue = "{{ $product->stock }}";
        document.getElementById('numberInput').addEventListener('input', function () {
            let value = parseInt(this.value);
            if (value > maxValue) {
                this.value = maxValue;
            } else if (value < 1) {
                this.value = 1;
            }
        });
    </script>
@endsection
