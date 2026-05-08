<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Carts;

class CartController extends Controller
{
    public function AddToCart(Request $request)
    {
        if (!Auth::guard('customer')->check()) {
            return response()->json(['status' => 'error', 'message' => 'Please login first to add items to cart.'], 401);
        }

        $customer_id = Auth::guard('customer')->id();
        $product_id = $request->product_id;
        $variant_id = $request->variant_id; // Can be null
        $quantity = $request->quantity ?? 1;

        // Check if item already exists in cart
        $cartItem = Carts::where('customer_id', $customer_id)
            ->where('product_id', $product_id)
            ->where('variant_id', $variant_id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $quantity);
        } else {
            Carts::create([
                'customer_id' => $customer_id,
                'product_id' => $product_id,
                'variant_id' => $variant_id,
                'quantity' => $quantity,
            ]);
        }

        return response()->json(['status' => 'success', 'message' => 'Product added to cart successfully.']);
    }

    public function GetCart()
    {
        $cartItems = [];
        if (Auth::guard('customer')->check()) {
            $cartItems = Carts::with(['product.uniformCategory', 'variant'])
                ->where('customer_id', Auth::guard('customer')->id())
                ->get();
        }

        return view('components.cart_drawer_content', compact('cartItems'))->render();
    }

    public function UpdateQuantity(Request $request)
    {
        $cart = Carts::find($request->id);
        if (!$cart) return response()->json(['status' => 'error', 'message' => 'Item not found.']);

        $newQty = $cart->quantity + $request->change;
        if ($newQty < 1) return response()->json(['status' => 'error', 'message' => 'Minimum quantity is 1.']);

        $cart->quantity = $newQty;
        $cart->save();

        return response()->json(['status' => 'success']);
    }

    public function RemoveItem($id)
    {
        $cart = Carts::find($id);
        if ($cart) $cart->delete();

        return response()->json(['status' => 'success', 'message' => 'Item removed from bag.']);
    }
}
