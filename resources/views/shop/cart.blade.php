@extends('layouts.shop')

@section('title', 'Cart')

@section('content')
    <h1 class="text-3xl font-bold mb-4">Your Cart</h1>
    <ul class="list-disc pl-5">
        @foreach($cartItems as $item)
            <li class="mb-2">{{ $item->name }} - ${{ $item->price }} x {{ $item->quantity }}</li>
        @endforeach
    </ul>
@endsection
