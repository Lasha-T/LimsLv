@extends('layouts.shop')

@section('title', 'Cart')

@section('content')
<div class="flex justify-center px-4"> 
    <div class="max-w-4xl w-full">
    <h1 class="text-3xl font-bold mb-4">Your Cart</h1>

    @if($cartItems->count() > 0)
        <ul class="list-disc pl-5">
            @foreach($cartItems as $item)
                <li class="mb-2">
                    {{ $item->name }} - ${{ $item->price }} x {{ $item->pivot->quantity }}
                    <form action="{{ route('shop.cart.add', $item->id) }}" method="POST" class="inline-block ml-4">
                        @csrf
                        <input type="number" name="quantity" value="{{ $item->pivot->quantity }}" min="1" class="border p-1 w-16">
                        <button type="submit" class="bg-blue-500 text-white text-sm px-2 py-1 ml-3 rounded">Update</button>
                    </form>
                    <form action="{{ route('shop.cart.remove', $item->id) }}" method="POST" class="inline-block ml-4">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white text-sm px-2 py-1 rounded">X</button>
                    </form>
                </li>
            @endforeach
        </ul>

        <div class="mt-6">
            <p class="text-lg">Total: <strong class="ml-1">${{ number_format($cartItems->sum(fn($item) => $item->price * $item->pivot->quantity), 2) }}</strong></p>
        </div>

        <div class="mt-4">
            <form action="{{ route('cart.checkout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded">Proceed to Checkout</button>
            </form>
        </div>
    @else
        <p>Your cart is empty.</p>
    @endif
    </div>
</div>
@endsection
