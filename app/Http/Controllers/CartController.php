<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Add a product to the cart
    public function addToCart(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
    
        // Check if requested quantity is available
        if ($request->quantity > $product->stock) {
            return redirect()->back()->with('error', 'Not enough stock available.');
        }
    
        $order = Order::firstOrCreate(
            ['user_id' => Auth::id(), 'status' => 'pending'], // Create a new pending order if one doesn't exist
            ['total_amount' => 0]
        );
    
        // Add product to order with the specified quantity
        $existingOrderProduct = OrderProduct::where('order_id', $order->id)
                                            ->where('product_id', $productId)
                                            ->first();
    
        if ($existingOrderProduct) {
            // If product already in order, update the quantity
            $existingOrderProduct->quantity += $request->quantity;
            $existingOrderProduct->save();
        } else {
            // Otherwise, add new product to order
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $request->quantity,
            ]);
        }
    
        // Deduct stock from the product
        $product->stock -= $request->quantity;
        $product->save();
    
        return redirect()->route('shop.cart')->with('success', 'Product added to cart.');
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
            $orderProduct = $order->products()->where('product_id', $productId)->first();
            
            if ($orderProduct) {
                // Return the product's quantity back to stock
                $product = Product::findOrFail($productId);
                $product->stock += $orderProduct->pivot->quantity;
                $product->save();
    
                // Remove the product from the order
                $order->products()->detach($productId);
            }
    
            return redirect()->route('shop.cart')->with('success', 'Product removed from cart and stock restored.');
        }
    
        return redirect()->back()->with('error', 'No active order found.');
    }
    

    public function updateCart(Request $request, $productId)
    {
        $order = Order::where('user_id', Auth::id())
                      ->where('status', 'pending')
                      ->first();
    
        if ($order) {
            $orderProduct = $order->products()->where('product_id', $productId)->first();
            
            if ($orderProduct) {
                $oldQuantity = $orderProduct->pivot->quantity;
                $newQuantity = $request->quantity;
    
                // Adjust the stock based on the quantity difference
                $product = Product::findOrFail($productId);
                if ($newQuantity > $oldQuantity) {
                    $quantityDifference = $newQuantity - $oldQuantity;
                    if ($quantityDifference > $product->stock) {
                        return redirect()->back()->with('error', 'Not enough stock available.');
                    }
                    $product->stock -= $quantityDifference;
                } else {
                    $quantityDifference = $oldQuantity - $newQuantity;
                    $product->stock += $quantityDifference;
                }
                $product->save();
    
                // Update the quantity in the pivot table
                $order->products()->updateExistingPivot($productId, ['quantity' => $newQuantity]);
            }
    
            return redirect()->route('shop.cart')->with('success', 'Cart updated successfully.');
        }
    
        return redirect()->back()->with('error', 'No active order found.');
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
    
        // Recalculate the total based on the current cart items
        $totalAmount = $cartItems->sum(function ($product) {
            return $product->price * $product->pivot->quantity;
        });
    
        // Update the order with the recalculated total amount
        $order->total_amount = $totalAmount;
        $order->save(); // Save the recalculated total in the database
    
        return view('shop.checkout', compact('order', 'cartItems', 'totalAmount'));
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
            // Loop through each product in the order
            foreach ($order->products as $product) {
                // Return the quantity of the product back to its stock
                $product->stock += $product->pivot->quantity;
                $product->save();
            }
    
            // Mark the order as canceled
            $order->status = 'canceled';
            $order->save();
    
            // Remove all products in the order (optional, depending on logic)
            OrderProduct::where('order_id', $order->id)->delete();
    
            // Clear the cart
            session()->forget('cart');
    
            return redirect()->route('shop.cart')->with('success', 'Order discarded, quantities restored, cart cleared.');
        }
    
        return redirect()->back()->with('error', 'No active order found to discard.');
    }  

}
