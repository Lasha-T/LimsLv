<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Add a product to the cart
    public function addToCart(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        // Get the current order (cart) for the logged-in user
        $order = Order::firstOrCreate(
            ['user_id' => Auth::id(), 'status' => 'pending'],
            ['total_amount' => 0]
        );

        // Add or update product in the pivot table
        $order->products()->syncWithoutDetaching([
            $productId => ['quantity' => $request->quantity]
        ]);

        // Update total amount
        $order->total_amount += $product->price * $request->quantity;
        $order->save();

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    // View cart (current pending order)
    public function viewCart()
    {
        // Retrieve the pending order for the authenticated user
        $order = Order::where('user_id', Auth::id())
                      ->where('status', 'pending')
                      ->with('products') // Eager load products
                      ->first();

        $cartItems = $order ? $order->products : collect();  // `collect()` ensures it's a Collection
    
        return view('shop.cart', compact('cartItems'));
    }
    
    

    // Remove product from cart
    public function removeFromCart($productId)
    {
        $order = Order::where('user_id', Auth::id())
                      ->where('status', 'pending')
                      ->first();

        if ($order) {
            $order->products()->detach($productId);
            $this->updateTotalAmount($order);

            return redirect()->back()->with('success', 'Product removed from cart.');
        }

        return redirect()->back()->with('error', 'Cart not found.');
    }

    // Helper method to update the total amount
    protected function updateTotalAmount($order)
    {
        $total = $order->products->sum(function ($product) {
            return $product->price * $product->pivot->quantity;
        });

        $order->total_amount = $total;
        $order->save();
    }

    public function checkout()
    {
        $order = Order::where('user_id', Auth::id())
                      ->where('status', 'pending')
                      ->first();
    
        if ($order) {
            // Redirect to the checkout page without changing the order status
            return redirect()->route('cart.checkout.page')->with('success', 'Ready to proceed with payment!');
        }
    
        return redirect()->back()->with('error', 'No active cart found.');
    }
    

    public function checkoutPage()
    {
        $order = Order::where('user_id', Auth::id())
                    ->where('status', 'pending')
                    ->first();

        if (!$order) {
            return redirect()->route('shop.cart')->with('error', 'No active cart found.');
        }

        // Get the items in the order with their quantities
        $cartItems = $order->products;

        return view('shop.checkout', compact('order', 'cartItems'));
    }

    // Confirm the payment
    public function confirmPayment(Request $request)
    {
        $order = Order::where('user_id', Auth::id())
                        ->where('status', 'pending')
                        ->first();

        if ($order) {
            // Mark the order as completed
            $order->status = 'completed';
            $order->save();

            // Clear the cart (optional)
            session()->forget('cart');

            return redirect()->route('shop.home')->with('success', 'Payment confirmed, order completed!');
        }

        return redirect()->back()->with('error', 'No active order found.');
    }

    // Discard the order and clear the cart
    public function discardOrder(Request $request)
    {
        $order = Order::where('user_id', Auth::id())
                      ->where('status', 'pending')
                      ->first();

        if ($order) {
            // Mark the order as canceled
            $order->status = 'canceled';
            $order->save();

            // Clear the cart
            session()->forget('cart');

            return redirect()->route('shop.cart')->with('success', 'Order discarded, cart cleared.');
        }

        return redirect()->back()->with('error', 'No active order found to discard.');
    }

}
