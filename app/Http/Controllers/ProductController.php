<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
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

    /**
     * @OA\Get(
     *     path="/products",
     *     tags={"Products"},
     *     summary="Get all products",
     *     description="Get all products",
     *     @OA\Response(
     *         response=200,
     *         description="All Products"
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
     *             @OA\Property(property="protein", type="number", format="float", default=0)
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
            'name' => 'required'
        ]);

        $request['user_id'] = 1;
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
     *             @OA\Property(property="name", type="string", description="The name of the product", example="Coca Cola"),
     *             @OA\Property(property="api_id", type="string", nullable=true, description="External API ID for the product", example="1234"),
     *             @OA\Property(property="image", type="string", nullable=true, description="URL of the product image", example="http://example.com/image.png"),
     *             @OA\Property(property="country", type="string", nullable=true, description="Country of origin of the product", example="France"),
     *             @OA\Property(property="brand", type="string", nullable=true, description="The brand of the product", example="Coca Cola Company"),
     *             @OA\Property(property="description", type="string", nullable=true, description="Description of the product", example="A refreshing soda."),
     *             @OA\Property(property="category", type="string", nullable=true, description="Category of the product", example="Beverages"),
     *             @OA\Property(property="tags", type="string", nullable=true, description="Tags associated with the product", example="soda,beverage,refreshing"),
     *             @OA\Property(property="ingredients", type="string", nullable=true, description="Ingredients of the product", example="Water, Sugar, Carbon Dioxide"),
     *             @OA\Property(property="serving_size_unit", type="string", nullable=true, description="Unit of the serving size", example="ml"),
     *             @OA\Property(property="serving_size", type="number", format="float", nullable=true, description="Size of one serving", example=330),
     *             @OA\Property(property="calories", type="number", format="float", default=0, description="Calories per serving", example=139),
     *             @OA\Property(property="fat", type="number", format="float", default=0, description="Fat content per serving", example=0),
     *             @OA\Property(property="carbohydrates", type="number", format="float", default=0, description="Carbohydrates per serving", example=35),
     *             @OA\Property(property="protein", type="number", format="float", default=0, description="Protein content per serving", example=0)
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
        $request->validate([
            'name' => 'required'
        ]);

        $product->update($request->all());

        return response()->json($product);
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

    public function page(User $user, int $pageNumber = 1)
    {
        $offset = ($pageNumber - 1) * self::$pageSize;

        $products = $user->products()
            ->skip($offset)
            ->take(self::$pageSize)
            ->get();

        $pageCount = ceil($user->products()->count() / self::$pageSize);

        return response()->json([
            'products' => $products,
            'pageCount' => $pageCount
        ]);
    }
}
