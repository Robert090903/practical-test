<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::all();
    }

    public function store(Request $request)
    {
        $randomNames = ['Electronics', 'Fashion', 'Books', 'Sports', 'Home', 'Food', 'Beauty', 'Toys', 'Garden', 'Automotive'];
        $randomDesc = ['Featured Items', 'Best Sellers', 'Top Collection', 'Premium Selection', 'Exclusive Items', 'Special Collection', 'Trending Items'];
        
        $validated = [
            'name' => $randomNames[array_rand($randomNames)],
            'description' => $randomDesc[array_rand($randomDesc)]
        ];

        $category = Category::create($validated);

        return response()->json([
            'message' => 'Category created successfully',
            'data' => $category
        ], 200);
    }

    public function show($id)
    {
        return Category::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255|unique:categories,name,'.$id,
            'description' => 'sometimes|nullable|string'
        ]);

        if (empty($validated)) {
            $randomNames = ['Electronics', 'Fashion', 'Books', 'Sports', 'Home', 'Food', 'Beauty', 'Toys', 'Garden', 'Automotive'];
            $randomDesc = ['Featured Items', 'Best Sellers', 'Top Collection', 'Premium Selection', 'Exclusive Items', 'Special Collection', 'Trending Items'];
            
            $validated = [
                'name' => $randomNames[array_rand($randomNames)],
                'description' => $randomDesc[array_rand($randomDesc)]
            ];
        }

        $oldData = $category->toArray();
        $category->forceFill($validated);
        $category->save();
        $category->refresh();

        return response()->json([
            'message' => 'Category updated successfully',
            'old_data' => $oldData,
            'new_data' => $category,
            'changes_made' => $validated
        ], 200);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully'], 200);
    }
}
