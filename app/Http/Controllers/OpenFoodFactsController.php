<?php

namespace App\Http\Controllers;

use App\Models\Product;
use GuzzleHttp\Client;

/**
 * @OA\Tag(
 *     name="Open Food Facts",
 *     description="Fetch Open Food Facts API (https://fr.openfoodfacts.org/)"
 * )
 */
class OpenFoodFactsController extends Controller
{
    protected $client;
    protected static $pageSize = 12;
    protected static $fields = "code,product_name,brands,image_url";


    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://fr.openfoodfacts.org/api/v2/',
            'verify' => false
        ]);
    }

    /**
     * @OA\Get(
     *     path="/off/food/search/{query}/{page}",
     *     tags={"Open Food Facts"},
     *     summary="Search for food",
     *     @OA\Parameter(
     *         name="query",
     *         in="path",
     *         required=true,
     *         description="Search query",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="path",
     *         required=false,
     *         description="Page number",
     *         @OA\Schema(
     *             type="integer",
     *             default=1,
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of food products from Open Food Facts"
     *     )
     * )
     */
    public function search(string $query, int $page = 1)
    {
        $response = $this->client->request('GET', "search", [
            'query' => [
                'categories_tags_fr' => $query,
                'page_size' => self::$pageSize,
                'page' => $page,
                'fields' => self::$fields
            ]
        ]);

        $apiResult = json_decode($response->getBody()->getContents(), true);

        $products = collect($apiResult['products'])->map(function ($apiProduct) {
            $product = new Product([
                'api_id' => $apiProduct['code'] ?? null,
                'name'   => $apiProduct['product_name'] ?? null,
                'image'  => $apiProduct['image_url'] ?? null,
                'brand'  => $apiProduct['brands'] ?? null,
            ]);

            return $product;
        });

        return response()->json([
            'products'  => $products,
            'pageCount' => ceil($apiResult['count'] / $apiResult['page_size']),
        ]);
    }

    /**
     * @OA\Get(
     *     path="/off/food/{id}",
     *     tags={"Open Food Facts"},
     *     summary="Get food product",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Product ID",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product"
     *     )
     * )
     */
    public function show(string $id)
    {
        $response = $this->client->request('GET', "product/$id");

        $apiResult = json_decode($response->getBody()->getContents(), true);
        $apiProduct = $apiResult['product'];

        $product = new Product([
            'api_id'            => $apiResult['code'] ?? null,
            'name'              => $apiProduct['product_name'] ?? null,
            'image'             => $apiProduct['image_url'] ?? null,
            'country'           => null,
            'brand'             => $apiProduct['brands'] ?? null,
            'description'       => $apiProduct['product_name'] ?? null,
            'category'          => null,
            'tags'              => $apiProduct['categories'] ?? null,
            'ingredients'       => $apiProduct['ingredients_text_fr_imported'] ?? null,
            'serving_size_unit' => null,
            'serving_size'      => null,
            'calories'          => null,
            'fat'               => null,
            'carbohydrates'     => null,
            'protein'           => null,
        ]);

        return response()->json($product);
    }
}