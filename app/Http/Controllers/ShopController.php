<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function ShopPage(Request $request)
    {
        $query = \Illuminate\Support\Facades\DB::table('products')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'categories.category_name');

        // Apply Category Filter
        if ($request->has('category') && $request->category != 'all') {
            $query->where('categories.category_name', $request->category);
        }

        // Apply Price Filter
        if ($request->has('max_price')) {
            $query->where(function($q) use ($request) {
                $q->where('products.product_price', '<=', $request->max_price)
                  ->orWhereExists(function ($sub) use ($request) {
                      $sub->select(\Illuminate\Support\Facades\DB::raw(1))
                          ->from('products_variants')
                          ->whereColumn('products_variants.product_id', 'products.id')
                          ->where('products_variants.price', '<=', $request->max_price);
                  });
            });
        }

        // Apply Search Filter
        if ($request->has('search')) {
            $query->where('products.product_name', 'LIKE', '%' . $request->search . '%');
        }

        $products = $query->orderBy('products.id', 'desc')->get();

        // Attach display price (min and max variant price if applicable)
        foreach ($products as $product) {
            if ($product->has_variant) {
                $variantData = \Illuminate\Support\Facades\DB::table('products_variants')
                    ->where('product_id', $product->id)
                    ->get();
                
                $product->min_price = $variantData->min('price');
                $product->max_price = $variantData->max('price');
                $product->display_price = $product->min_price;
                $product->available_sizes = $variantData->pluck('size')->implode(', ');
            } else {
                $product->display_price = $product->product_price;
                $product->min_price = $product->product_price;
                $product->max_price = $product->product_price;
            }
        }

        $categories = \Illuminate\Support\Facades\DB::table('categories')->get();

        $cartItems = [];
        if (\Illuminate\Support\Facades\Auth::guard('customer')->check()) {
            $cartItems = \App\Models\Carts::with(['product', 'variant'])
                ->where('customer_id', \Illuminate\Support\Facades\Auth::guard('customer')->id())
                ->get();
        }

        return view('shop', compact('products', 'categories', 'cartItems'));
    }
    public function GetProductDetails($id)
    {
        $product = \Illuminate\Support\Facades\DB::table('products')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'categories.category_name')
            ->where('products.id', $id)
            ->first();

        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'Product not found.'], 404);
        }

        $variants = \Illuminate\Support\Facades\DB::table('products_variants')
            ->where('product_id', $id)
            ->get();

        return response()->json([
            'status' => 'success',
            'product' => $product,
            'variants' => $variants
        ]);
    }

    public function SingleProductPage()
    {
        return view('single_product');
    }
}
