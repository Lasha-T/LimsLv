<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Active Orders: Includes pending_shipment and shipped orders
    public function activeOrders()
    {
        // Check if the authenticated user is an admin
        if (auth()->user()->role === 'admin' || auth()->user()->role === 'adminguest') {
            // Admins see all active orders
            $orders = Order::whereIn('status', ['pending_shipment', 'shipped'])
                            ->with('products', 'user')
                            ->orderBy('created_at', 'desc')
                            ->paginate(5);
        } else {
            // Customers see only their active orders
            $orders = Order::whereIn('status', ['pending_shipment', 'shipped'])
                            ->where('user_id', auth()->id()) // Filter by authenticated user ID
                            ->with('products', 'user')
                            ->orderBy('created_at', 'desc')
                            ->paginate(5);
        }
    
        return view('orders.active', compact('orders'));
    }
      

    // Finished Orders: Includes delivered orders
    public function finishedOrders()
    {
        // Check if the authenticated user is an admin
        if (auth()->user()->role === 'admin' || auth()->user()->role === 'adminguest') {
            // Admins see all finished orders
            $orders = Order::where('status', 'delivered')
                            ->with('products', 'user')
                            ->orderBy('created_at', 'desc')
                            ->paginate(5);
        } else {
            // Customers see only their finished orders
            $orders = Order::where('status', 'delivered')
                            ->where('user_id', auth()->id()) // Filter by authenticated user ID
                            ->with('products', 'user')
                            ->orderBy('created_at', 'desc')
                            ->paginate(5);
        }
    
        return view('orders.finished', compact('orders'));
    }
    

    // Canceled Orders: Includes canceled orders
    public function canceledOrders()
    {
        // Check if the authenticated user is an admin
        if (auth()->user()->role === 'admin' || auth()->user()->role === 'adminguest') {
            // Admins see all canceled orders
            $orders = Order::where('status', 'canceled')
                            ->with('products', 'user')
                            ->orderBy('created_at', 'desc')
                            ->paginate(5);
        } else {
            // Customers see only their canceled orders
            $orders = Order::where('status', 'canceled')
                            ->where('user_id', auth()->id()) // Filter by authenticated user ID
                            ->with('products', 'user')
                            ->orderBy('created_at', 'desc')
                            ->paginate(5);
        }
    
        return view('orders.canceled', compact('orders'));
    }
        

    // Update order status
    public function updateOrderStatus(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        $request->validate([
            'status' => 'required|in:pending,canceled,pending_shipment,shipped,delivered'
        ]);

        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Order status updated successfully!');
    }  
    
    // show Order Details
    public function showOrderDetails(Order $order)
    {
        $order->load('products');  // Load the products in the order with pivot data

        return view('orders.details', compact('order'));
    }
}
