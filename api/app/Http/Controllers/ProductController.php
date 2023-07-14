<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index()
    {
        $products = Product::all();

        return response()->json($products);
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'serving_size' => 'required',
            'energy' => 'required',
            'protein' => 'required',
            'total_fat' => 'required',
            'saturated_fat' => 'required',
            'carbohydrates' => 'required',
            'sugars' => 'required',
            'sodium' => 'required'
        ]);

        $product = Product::create($validatedData);

        return response()->json($product, 201);
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        return response()->json($product);
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'serving_size' => 'required',
            'energy' => 'required',
            'protein' => 'required',
            'total_fat' => 'required',
            'saturated_fat' => 'required',
            'carbohydrates' => 'required',
            'sugars' => 'required',
            'sodium' => 'required'
        ]);

        $product->update($validatedData);

        return response()->json($product);
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(null, 204);
    }
}
