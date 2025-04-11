<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return Product::all();
    }

    public function store(Request $request)
    {
        $categoryIds = \App\Models\Category::pluck('id')->toArray();
        
        $randomProducts = ['MacBook Pro', 'iPhone Pro Max', 'iPad Air', 'Apple Watch', 'Sony Camera', 'Bose Headphones', 'Samsung TV', 'Gaming Console', 'Wireless Earbuds', 'Smart Speaker'];
        $randomDesc = ['Latest Generation', 'Premium Edition', 'Professional Series', 'Limited Collection', 'Signature Series', 'Elite Model', 'Advanced Version', 'Ultimate Package'];
        
        $validated = [
            'name' => $randomProducts[array_rand($randomProducts)],
            'description' => $randomDesc[array_rand($randomDesc)],
            'price' => rand(100, 1000) + (rand(0, 99) / 100),
            'quantity' => rand(1, 50),
            'category_id' => $categoryIds[array_rand($categoryIds)]
        ];

        $product = Product::create($validated);

        return response()->json([
            'message' => 'Product created successfully',
            'data' => $product
        ], 200);
    }

    public function show($id)
    {
        return Product::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|nullable|string',
            'price' => 'sometimes|numeric|min:0',
            'quantity' => 'sometimes|integer|min:0',
            'category_id' => 'sometimes|exists:categories,id'
        ]);

        // Get existing category IDs
        $categoryIds = \App\Models\Category::pluck('id')->toArray();
        
        $randomProducts = ['MacBook Pro', 'iPhone Pro Max', 'iPad Air', 'Apple Watch', 'Sony Camera', 'Bose Headphones', 'Samsung TV', 'Gaming Console', 'Wireless Earbuds', 'Smart Speaker'];
        $randomDesc = ['Latest Generation', 'Premium Edition', 'Professional Series', 'Limited Collection', 'Signature Series', 'Elite Model', 'Advanced Version', 'Ultimate Package'];
        
        $validated = [
            'name' => $randomProducts[array_rand($randomProducts)],
            'description' => $randomDesc[array_rand($randomDesc)],
            'price' => rand(100, 1000) + (rand(0, 99) / 100),
            'quantity' => rand(1, 50),
            'category_id' => $categoryIds[array_rand($categoryIds)] // Use existing category ID
        ];

        $oldData = $product->toArray();
        $product->forceFill($validated);
        $product->save();
        $product->refresh();

        return response()->json([
            'message' => 'Product updated successfully',
            'old_data' => $oldData,
            'new_data' => $product,
            'changes_made' => $validated
        ], 200);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}
