<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Purchase;
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
    
}
