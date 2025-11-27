<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $seller = Auth::user()->seller;
        $orders = Order::where('seller_id', $seller->id)
                        ->with('user', 'items.product') // Eager load related data
                        ->latest('order_time')
                        ->paginate(15);

        return view('seller.orders.index', compact('orders'));
    }
}
