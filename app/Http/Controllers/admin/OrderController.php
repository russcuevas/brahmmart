<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use App\Models\OrderItems;
use App\Models\Products;
use App\Models\ProductsVariant;
use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;
use App\Mail\WalkinReceipt;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function UpdateNote(Request $request, $id)
    {
        $order = Orders::findOrFail($id);
        $order->order_note = $request->order_note;
        $order->save();

        return response()->json(['success' => true]);
    }

    public function UpdateItemNote(Request $request, $id)
    {
        $item = OrderItems::findOrFail($id);
        $item->sizing_notes = $request->sizing_notes;
        $item->save();

        return response()->json(['success' => true]);
    }

    public function OrdersPage()
    {
        $orders = Orders::with(['customer', 'items.product', 'items.variant'])->latest()->get();
        $products = Products::all();
        $variants = ProductsVariant::all();
        $customers = Customers::all();
        return view('admins.orders.index', compact('orders', 'products', 'variants', 'customers'));
    }

    public function UpdateStatus(Request $request, $id)
    {
        $order = Orders::with(['customer', 'items.product', 'items.variant'])->findOrFail($id);
        $oldStatus = $order->status;
        $order->status = $request->status;

        if ($request->filled('pick_up_date')) {
            $order->pick_up_date = $request->pick_up_date;
        }

        $order->save();

        // If status changed to completed, deduct stocks AND send email
        if ($oldStatus != 'completed' && $request->status == 'completed') {
            foreach ($order->items as $item) {
                if ($item->variant) {
                    $item->variant->decrement('stocks', $item->quantity);
                } else {
                    $item->product->decrement('stocks', $item->quantity);
                }
            }

            try {
                Mail::to($order->customer->email)->send(new OrderConfirmation($order));
            } catch (\Exception $e) {
                \Log::error('Failed to send status update email: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Order status updated successfully!');
    }

    public function DeleteOrder($id)
    {
        $order = Orders::findOrFail($id);
        $order->delete();

        return back()->with('success', 'Order deleted successfully!');
    }

    public function StoreWalkinOrder(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.variant_id' => 'nullable|exists:products_variants,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            // Find or create a walk-in customer
            $customer = Customers::where('email', $request->email)->first();
            if (!$customer) {
                $customer = Customers::create([
                    'fullname' => $request->fullname,
                    'email' => $request->email,
                    'address' => $request->address,
                    'gender' => 'Walk-in',
                    'phone_number' => 'N/A',
                    'password' => Hash::make('123456789'),
                    'is_verified' => 1,
                ]);
            }

            // Group items by is_emailable
            $groups = [
                'emailable' => ['items' => [], 'total' => 0, 'status' => 'processing'],
                'non_emailable' => ['items' => [], 'total' => 0, 'status' => 'completed']
            ];

            foreach ($request->items as $item) {
                $product = Products::findOrFail($item['product_id']);
                $price = $product->product_price;
                $variant = null;

                if (!empty($item['variant_id'])) {
                    $variant = ProductsVariant::findOrFail($item['variant_id']);
                    $price = $variant->price;
                }

                $itemTotal = $price * $item['quantity'];
                
                $itemData = [
                    'product_id' => $item['product_id'],
                    'variant_id' => $item['variant_id'] ?? null,
                    'quantity' => $item['quantity'],
                    'price_at_order' => $price,
                    'sizing_notes' => $item['sizing_notes'] ?? null,
                ];

                if ($product->is_emailable == 1) {
                    $groups['emailable']['items'][] = $itemData;
                    $groups['emailable']['total'] += $itemTotal;
                } else {
                    $groups['non_emailable']['items'][] = $itemData;
                    $groups['non_emailable']['total'] += $itemTotal;
                    
                    // Deduct stocks ONLY for items that are completed immediately (non-emailable)
                    if ($variant) {
                        $variant->decrement('stocks', $item['quantity']);
                    } else {
                        $product->decrement('stocks', $item['quantity']);
                    }
                }
            }

            // Create orders for each group that has items
            $createdOrders = [];
            foreach ($groups as $group) {
                if (!empty($group['items'])) {
                    $order = Orders::create([
                        'customer_id' => $customer->id,
                        'total_price' => $group['total'],
                        'status' => $group['status'],
                        'order_note' => $request->order_note,
                    ]);

                    foreach ($group['items'] as $itemData) {
                        $itemData['order_id'] = $order->id;
                        OrderItems::create($itemData);
                    }
                    
                    $createdOrders[] = $order;
                }
            }

            // Send ONE consolidated email for all walk-in orders
            if (!empty($createdOrders)) {
                try {
                    Mail::to($customer->email)->send(new WalkinReceipt($createdOrders, $customer));
                } catch (\Exception $e) {
                    \Log::error('Failed to send walk-in receipt: ' . $e->getMessage());
                }
            }

            DB::commit();
            return back()->with('success', 'Walk-in order created successfully! A consolidated receipt has been sent to ' . $customer->email);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create order: ' . $e->getMessage());
        }
    }
}
