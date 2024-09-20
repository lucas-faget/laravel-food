<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Products",
 *     description="Products"
 * )
 */
class ProductController extends Controller
{
    protected static $pageSize = 12;

    protected function validateProduct(Request $request)
    {
        return $request->validate([
            'name' => 'string',
            'api_id' => 'nullable|string',
            'image' => 'nullable|string',
            'country' => 'nullable|string',
            'brand' => 'nullable|string',
            'description' => 'nullable|string',
            'category' => 'nullable|string',
            'tags' => 'nullable|string',
            'ingredients' => 'nullable|string',
            'serving_size_unit' => 'nullable|string',
            'serving_size' => 'numeric',
            'calories' => 'numeric',
            'fat' => 'numeric',
            'carbohydrates' => 'numeric',
            'protein' => 'numeric',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/products",
     *     tags={"Products"},
     *     summary="Get all products",
     *     description="Get all products",
     *     @OA\Response(
     *         response=200,
     *         description="All products"
     *     )
     * )
     */
    public function index()
    {
        $products = Product::all();

        return response()->json($products);
    }

    /**
     * @OA\Get(
     *     path="/products/{id}",
     *     tags={"Products"},
     *     summary="Get a product by ID",
     *     description="Get a product by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Product ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product"
     *     )
     * )
     */
    public function show(Product $product)
    {
        return response()->json($product);
    }

    /**
     * @OA\Post(
     *     path="/products",
     *     tags={"Products"},
     *     summary="Create a product",
     *     description="Create a product",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="api_id", type="string", nullable=true),
     *             @OA\Property(property="image", type="string", nullable=true),
     *             @OA\Property(property="country", type="string", nullable=true),
     *             @OA\Property(property="brand", type="string", nullable=true),
     *             @OA\Property(property="description", type="string", nullable=true),
     *             @OA\Property(property="category", type="string", nullable=true),
     *             @OA\Property(property="tags", type="string", nullable=true),
     *             @OA\Property(property="ingredients", type="string", nullable=true),
     *             @OA\Property(property="serving_size_unit", type="string", nullable=true),
     *             @OA\Property(property="serving_size", type="number", format="float", nullable=true),
     *             @OA\Property(property="calories", type="number", format="float", default=0),
     *             @OA\Property(property="fat", type="number", format="float", default=0),
     *             @OA\Property(property="carbohydrates", type="number", format="float", default=0),
     *             @OA\Property(property="protein", type="number", format="float", default=0),
     *             @OA\Property(property="user_id", type="integer"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Product created successfully",
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);

        $this->validateProduct($request);

        $product = Product::create($request->all());

        return response()->json($product, 201);
    }

    /**
     * @OA\Put(
     *     path="/products/{id}",
     *     tags={"Products"},
     *     summary="Update a product",
     *     description="Update a product",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Product ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="api_id", type="string", nullable=true),
     *             @OA\Property(property="image", type="string", nullable=true),
     *             @OA\Property(property="country", type="string", nullable=true),
     *             @OA\Property(property="brand", type="string", nullable=true),
     *             @OA\Property(property="description", type="string", nullable=true),
     *             @OA\Property(property="category", type="string", nullable=true),
     *             @OA\Property(property="tags", type="string", nullable=true),
     *             @OA\Property(property="ingredients", type="string", nullable=true),
     *             @OA\Property(property="serving_size_unit", type="string", nullable=true),
     *             @OA\Property(property="serving_size", type="number", format="float", nullable=true),
     *             @OA\Property(property="calories", type="number", format="float", default=0),
     *             @OA\Property(property="fat", type="number", format="float", default=0),
     *             @OA\Property(property="carbohydrates", type="number", format="float", default=0),
     *             @OA\Property(property="protein", type="number", format="float", default=0),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product updated successfully",
     *     )
     * )
     */
    public function update(Request $request, Product $product)
    {
        $this->validateProduct($request);

        $product->update($request->all());

        return response()->json($product, 200);
    }

    /**
     * @OA\Delete(
     *     path="/products/{id}",
     *     tags={"Products"},
     *     summary="Delete a product",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Product ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Product deleted successfully"
     *     )
     * )
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(null, 204);
    }
}
