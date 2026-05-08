<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function InventoryPage()
    {
        $products = DB::table('products')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('uniform_categories', 'products.uniform_category_id', '=', 'uniform_categories.id')
            ->select('products.*', 'categories.category_name', 'uniform_categories.uniform_name')
            ->orderBy('products.id', 'desc')
            ->get();

        $variants = DB::table('products_variants')->get();
        $categories = DB::table('categories')->get();
        $uniform_categories = DB::table('uniform_categories')->get();

        // Calculate counts for summary
        $uniformCount = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->where('categories.category_name', 'Uniforms')
            ->count();

        $suppliesCount = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->where('categories.category_name', 'School Supplies')
            ->count();

        $booksCount = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->where('categories.category_name', 'Books')
            ->count();

        return view('admins.inventory.index', compact(
            'products',
            'variants',
            'categories',
            'uniform_categories',
            'uniformCount',
            'suppliesCount',
            'booksCount'
        ));
    }

    public function StoreProduct(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_description' => 'nullable|string',
            'category_id' => 'required|integer',
            'product_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $images = [];
        if ($request->hasFile('product_images')) {
            foreach ($request->file('product_images') as $image) {
                if ($image->isValid()) {
                    $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('images/products'), $imageName);
                    $images[] = 'images/products/' . $imageName;
                }
            }
        }

        $hasVariant = $request->has('has_variant');

        $productId = DB::table('products')->insertGetId([
            'category_id' => $request->category_id,
            'uniform_category_id' => $request->uniform_category_id,
            'product_name' => $request->product_name,
            'product_description' => $request->product_description,
            'product_price' => !$hasVariant ? $request->product_price : null,
            'product_image' => json_encode($images),
            'stocks' => !$hasVariant ? $request->stocks : null,
            'has_variant' => $hasVariant,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if ($hasVariant && $request->has('variants')) {
            foreach ($request->variants as $variant) {
                DB::table('products_variants')->insert([
                    'product_id' => $productId,
                    'size' => $variant['size'],
                    'price' => $variant['price'],
                    'stocks' => $variant['stocks'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return back()->with('success', 'Product added successfully!');
    }

    public function UpdateProduct(Request $request, $id)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_description' => 'nullable|string',
            'product_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = DB::table('products')->where('id', $id)->first();
        if (!$product) {
            return back()->with('error', 'Product not found.');
        }

        // Handle Images
        $images = [];

        // 1. Get existing images from hidden inputs (if any)
        if ($request->has('existing_images')) {
            $images = $request->input('existing_images');
        }

        // 2. Process new uploads
        if ($request->hasFile('product_images')) {
            $files = $request->file('product_images');
            foreach ($files as $image) {
                if ($image->isValid()) {
                    $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('images/products'), $imageName);
                    $images[] = 'images/products/' . $imageName;
                }
            }
        }

        // Update Product
        $updateData = [
            'category_id' => $request->category_id,
            'uniform_category_id' => $request->uniform_category_id,
            'product_name' => $request->product_name,
            'product_description' => $request->product_description,
            'product_image' => json_encode($images),
            'has_variant' => $request->has('has_variant'),
            'updated_at' => now(),
        ];

        if ($request->has('has_variant')) {
            $updateData['product_price'] = null;
            $updateData['stocks'] = null;
            
            // Handle Variants
            $submittedVariantIds = [];
            if ($request->has('variants')) {
                foreach ($request->variants as $vId => $vData) {
                    if (is_numeric($vId)) {
                        // Update Existing
                        DB::table('products_variants')->where('id', $vId)->update([
                            'size' => $vData['size'],
                            'price' => $vData['price'],
                            'stocks' => $vData['stocks'],
                            'updated_at' => now(),
                        ]);
                        $submittedVariantIds[] = $vId;
                    } else {
                        // Create New
                        $newVId = DB::table('products_variants')->insertGetId([
                            'product_id' => $id,
                            'size' => $vData['size'],
                            'price' => $vData['price'],
                            'stocks' => $vData['stocks'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                        $submittedVariantIds[] = $newVId;
                    }
                }
            }
            // Delete variants that were removed in the UI
            DB::table('products_variants')
                ->where('product_id', $id)
                ->whereNotIn('id', $submittedVariantIds)
                ->delete();

        } else {
            $updateData['product_price'] = $request->product_price;
            $updateData['stocks'] = $request->stocks;
            
            // Delete all variants if toggled off
            DB::table('products_variants')->where('product_id', $id)->delete();
        }

        DB::table('products')->where('id', $id)->update($updateData);

        return back()->with('success', 'Product updated successfully!');
    }

    public function DeleteProduct($id)
    {
        $product = DB::table('products')->where('id', $id)->first();
        if (!$product) {
            return back()->with('error', 'Product not found.');
        }

        // Delete Image files from storage
        if ($product->product_image) {
            $images = json_decode($product->product_image, true);
            if (is_array($images)) {
                foreach ($images as $image) {
                    $imagePath = public_path($image);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
            }
        }

        // Delete Variants first (Foreign key constraint safety)
        DB::table('products_variants')->where('product_id', $id)->delete();

        // Delete Product
        DB::table('products')->where('id', $id)->delete();

        return back()->with('success', 'Product deleted successfully!');
    }
}
