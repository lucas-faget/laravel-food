<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected static $pageSize = 12;

    public function index()
    {
        $products = Product::all();

        return response()->json($products);
    }

    public function page(int $pageNumber = 1)
    {
        $offset = ($pageNumber - 1) * self::$pageSize;

        $products = Product::skip($offset)->take(self::$pageSize)->get();
        $totalPages = ceil(Product::count() / self::$pageSize);

        return response()->json([
            'products' => $products,
            'totalPages' => $totalPages
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $product = Product::create($request->all());

        return response()->json($product, 201);
    }

    public function show(Product $product)
    {
        return response()->json($product);
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $product->update($request->all());

        return response()->json($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(null, 204);
    }
}
