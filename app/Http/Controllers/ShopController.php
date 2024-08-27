<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function home()
    {
        return view('shop.home');
    }

    public function products()
    {
        $products = Product::all();
        return view('shop.products', compact('products'));
    }

    public function showProduct($id)
    {
        $product = Product::findOrFail($id);
        return view('shop.showProduct', compact('product'));
    }

    public function cart()
    {
        $cartItems = [
            (object) ['name' => 'Product 1', 'price' => 10, 'quantity' => 1],
            (object) ['name' => 'Product 2', 'price' => 20, 'quantity' => 2],
        ];
        return view('shop.cart', compact('cartItems'));
    }
}
