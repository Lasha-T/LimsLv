<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    public function menu()
    {
        return view('products.menu');
    }
       
    public function create()
    {
        return view('products.create');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id); // Retrieves the product by ID or throws a 404 error if not found.
        return view('products.edit', compact('product')); // Pass the product data to the edit view.
    }

    public function update(Request $request, $id)
    {
        // Find the product by ID
        $product = Product::findOrFail($id);
    
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Max size: 2MB
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);
    
        // Handle the image upload if a new image is uploaded
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($product->image_path) {
                $oldImagePath = public_path('storage/' . $product->image_path);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
    
            // Store the new image
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('uploads', $imageName, 'public');
            $imagePath = 'uploads/' . $imageName;
    
            // Update the product image path
            $product->image_path = $imagePath;
        }
    
        // Update the product details with the validated data
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');
    
        // Save the updated product to the database
        $product->save();
    
        // Redirect back to the products index page with a success message
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }
    
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete the product image if it exists
        if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
            Storage::disk('public')->delete($product->image_path);
        }

        // Delete the product
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
    

    public function index()
    {
        $products = Product::paginate(5);
        return view('products.index', compact('products'));
    }        
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,gif|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('uploads', $imageName, 'public');
            $imagePath = 'uploads/' . $imageName;  
        }     

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('products.menu')->with('success', 'Product added successfully!');
    }

    // Show all orders to admin
    public function showOrders()
    {
        $orders = Order::with('products', 'user')->orderBy('created_at', 'desc')->get();

        return view('orders', compact('orders'));
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
}
