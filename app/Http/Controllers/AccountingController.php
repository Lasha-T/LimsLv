<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountingController extends Controller
{
    public function index()
    {
    $purchases = DB::table('purchases')
        ->join('products', 'purchases.product_id', '=', 'products.id')
        ->select('purchases.id', 'products.name as product_name', 'purchases.quantity', 'purchases.purchase_price as price', 'purchases.purchase_date as date')
        ->addSelect(DB::raw("'Purchase' as type"));
    
    $orders = DB::table('order_product')
        ->join('products', 'order_product.product_id', '=', 'products.id')
        ->join('orders', 'order_product.order_id', '=', 'orders.id')
        ->select('order_product.id', 'products.name as product_name', 'order_product.quantity', DB::raw('products.price as price'), 'orders.created_at as date')
        ->addSelect(DB::raw("'Order' as type"));
    
    $accountingData = $purchases
        ->union($orders)
        ->orderBy('date', 'desc')
        ->paginate(7);
    
    // Calculate totals
    $totalPurchases = DB::table('purchases')->sum(DB::raw('quantity * purchase_price'));
    $totalOrders = DB::table('order_product')
        ->join('products', 'order_product.product_id', '=', 'products.id')
        ->sum(DB::raw('order_product.quantity * products.price'));
    
    $profit = $totalOrders - $totalPurchases;
    
    return view('accounting.index', compact('accountingData', 'totalPurchases', 'totalOrders', 'profit'));   
    }

    public function selectProduct()
    {
        $products = Product::all(['id', 'name']);
        return view('accounting.select-product', compact('products'));
    }

    public function byProductView(Request $request)
    {
        $productId = $request->query('product_id');
        $product = Product::find($productId);

        if (!$product) {
            return redirect()->route('accounting.select-product')->with('error', 'Product not found.');
        }

        $purchases = Purchase::where('product_id', $product->id)->get()->map(function ($purchase) {
            return [
                'quantity' => $purchase->quantity,
                'total' => $purchase->purchase_price * $purchase->quantity,
                'purchase_date' => $purchase->purchase_date->format('Y-m-d'),
            ];
        });

        $orders = OrderProduct::where('product_id', $product->id)
            ->with(['order', 'product'])
            ->get()
            ->map(function ($orderProduct) {
                return [
                    'quantity' => $orderProduct->quantity,
                    'total' => $orderProduct->product->price * $orderProduct->quantity,
                    'order_date' => $orderProduct->order->created_at->format('Y-m-d'),
                ];
            });

        $totalPurchases = $purchases->sum('total');
        $totalOrders = $orders->sum('total');
        $profit = $totalOrders - $totalPurchases;

        return view('accounting.by-product', [
            'product' => $product,
            'purchases' => $purchases,
            'orders' => $orders,
            'totalPurchases' => $totalPurchases,
            'totalOrders' => $totalOrders,
            'profit' => $profit,
        ]);
    }


    
}
