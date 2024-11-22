<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchasesController extends Controller
{
    public function create()
    {
        $products = Product::all(); // Fetch all products
        return view('purchases.create', compact('products'));
    }
    
    public function store(Request $request)
    {
        // Validate the request and store the validated data in a variable
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'purchase_price' => 'required|numeric|min:0',
        ]);
    
        // Retrieve the product and increment its stock
        $product = Product::findOrFail($validatedData['product_id']);
        $product->increment('stock', $validatedData['quantity']);
    
        // Log the purchase in the purchases table
        Purchase::create([
            'product_id' => $validatedData['product_id'],
            'quantity' => $validatedData['quantity'],
            'purchase_price' => $validatedData['purchase_price'],
            'purchase_date' => now(), // Use Carbon's now() to store the current datetime
        ]);
    
        // Redirect back with a success message
        return redirect()->route('purchases.index')->with('success', 'Stock updated and purchase logged successfully!');
    }
    

    public function index()
    {
        $purchases = Purchase::with('product')->orderBy('created_at', 'desc')->paginate(10); // Paginate with 10 per page
        return view('purchases.index', compact('purchases'));
    }

}
