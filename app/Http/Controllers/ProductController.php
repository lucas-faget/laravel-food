<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Tag(
 *     name="Products",
 *     description="Products",
 * )
 */
class ProductController extends Controller
{
    protected static $pageSize = 12;

    protected $validations = [
        'name' => 'string|max:255',
        'api_id' => 'nullable|string|max:255',
        'image' => 'nullable|string',
        'country' => 'nullable|string|max:255',
        'brand' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'category' => 'nullable|string|max:255',
        'tags' => 'nullable|string',
        'ingredients' => 'nullable|string',
        'serving_size_unit' => 'nullable|string|max:50',
        'serving_size' => 'nullable|numeric|min:0',
        'calories' => 'nullable|numeric|min:0',
        'fat' => 'nullable|numeric|min:0',
        'carbohydrates' => 'nullable|numeric|min:0',
        'protein' => 'nullable|numeric|min:0',
    ];

    /**
     * @OA\Get(
     *     path="/products",
     *     tags={"Products"},
     *     summary="Get all products",
     *     @OA\Response(
     *         response=200,
     *         description="All products",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *     ),
     * )
     */
    public function index()
    {
        $user = Auth::user();
    
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $products = $user->products;

        return response()->json($products);
    }

    /**
     * @OA\Get(
     *     path="/products/{id}",
     *     tags={"Products"},
     *     summary="Get a product by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Product ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found",
     *     ),
     * )
     */
    public function show(Product $product)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if ($product->user_id !== $user->id) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($product);
    }

    /**
     * @OA\Post(
     *     path="/products",
     *     tags={"Products"},
     *     summary="Create a product",
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
     *         response=201,
     *         description="Product created successfully",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *     ),
     * )
     */
    public function store(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $validatedProduct = $request->validate($this->validations);

        $product = $user->products()->create($validatedProduct);

        return response()->json($product, 201);
    }

    /**
     * @OA\Put(
     *     path="/products/{id}",
     *     tags={"Products"},
     *     summary="Update a product",
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
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found",
     *     ),
     * )
     */
    public function update(Request $request, Product $product)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if ($product->user_id !== $user->id) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $validatedProduct = $request->validate($this->validations);

        $product->update($validatedProduct);

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
     *         description="Product deleted successfully",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found",
     *     ),
     * )
     */
    public function destroy(Product $product)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if ($product->user_id !== $user->id) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->delete();

        return response()->json(null, 204);
    }
}
