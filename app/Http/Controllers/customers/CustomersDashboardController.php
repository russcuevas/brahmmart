<?php

namespace App\Http\Controllers\customers;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomersDashboardController extends Controller
{
    public function DashboardPage()
    {
        $customer = Auth::guard('customer')->user();

        // 1. Get Active Orders Count (Not Completed and Not Cancelled)
        $activeOrdersCount = Orders::where('customer_id', $customer->id)
            ->whereNotIn('status', ['Completed', 'Cancelled'])
            ->count();

        // 2. Get Total Spent (Sum of completed orders)
        $totalSpent = Orders::where('customer_id', $customer->id)
            ->where('status', 'Completed')
            ->sum('total_price');

        // 3. ID Status (Based on is_verified or could be a separate logic)
        $idStatus = $customer->is_verified ? 'Verified' : 'Pending';

        // 4. Get Recent Orders (Latest 5) with relations for modal
        $recentOrders = Orders::where('customer_id', $customer->id)
            ->with(['items.product', 'items.variant'])
            ->latest()
            ->take(5)
            ->get();

        return view('customers.dashboard.index', compact(
            'activeOrdersCount',
            'totalSpent',
            'idStatus',
            'recentOrders'
        ));
    }
}
