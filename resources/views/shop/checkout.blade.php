@extends('layouts.shop')

@section('title', 'Checkout')

@section('content')
<div class="flex justify-center px-4"> 
    <div class="max-w-4xl w-full">
        <div class="container mx-auto p-4">
            <h1 class="text-3xl font-bold mb-4">Checkout</h1>

            @if(session('success'))
                <div class="bg-green-500 text-white p-3 mb-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-500 text-white p-3 mb-4 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <h2 class="text-xl font-semibold mb-2">Order Summary</h2>
            <ul class="list-disc pl-5">
                @foreach($cartItems as $item)
                    <li class="mb-2">
                        {{ $item->name }} - ${{ number_format($item->price, 2) }} x {{ $item->pivot->quantity }}
                    </li>
                @endforeach
            </ul>

            <div class="mt-4">
                <p class="text-lg">Total: <strong>${{ number_format($order->total_amount, 2) }}</strong></p>
            </div>

            <div class="mt-4 flex space-x-4">
                <form action="{{ route('cart.confirmPayment') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded">Confirm Payment</button>
                </form>

                <form action="{{ route('cart.discardOrder') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-500 text-white px-6 py-2 rounded">Discard Order</button>
                </form>
            </div>

            <div class="mt-4">
                <a href="{{ route('shop.cart') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded">Go Back</a>
            </div>
        </div>
    </div>
</div>
@endsection
