<?php

namespace App\Http\Controllers\customers;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyOrdersController extends Controller
{
    public function OrdersPage()
    {
        $customer = Auth::guard('customer')->user();

        // Get all orders for this customer with items and products
        $orders = Orders::where('customer_id', $customer->id)
            ->with(['items.product', 'items.variant'])
            ->latest()
            ->get();

        return view('customers.orders.index', compact('orders'));
    }
}
