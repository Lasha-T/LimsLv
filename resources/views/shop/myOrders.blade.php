@extends('layouts.shop')

@section('title', 'Orders')

@section('content')
<div class="flex justify-center px-4"> 
    <div class="max-w-4xl w-full">
    <h1 class="text-3xl font-bold mb-4">My Orders</h1>

    @foreach($orders as $order)
    <p>Order #{{ $order->id }} - Status: {{ ucfirst($order->status) }}</p>
    @endforeach

    </div>
</div>
@endsection
