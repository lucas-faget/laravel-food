<?php

namespace App\Http\Controllers;

use App\Models\Product;
use GuzzleHttp\Client;
use App\Http\Controllers\GoogleApiController;

/**
 * @OA\Tag(
 *     name="FoodData Central",
 *     description="Fetch FoodData Central API (https://fdc.nal.usda.gov/)"
 * )
 */
class FoodDataCentralController extends Controller
{
    protected $client;
    protected static $apiKey;
    protected static $pageSize = 12;
    protected static $enableGoogleImageApi = false;

    public function __construct()
    {
        self::$apiKey = env('FDC_API_KEY');
        
        $this->client = new Client([
            'base_uri' => 'https://api.nal.usda.gov/fdc/v1/',
            'verify' => false,
        ]);
    }

    /**
     * @OA\Get(
     *     path="/fdc/food/search/{query}/{page}",
     *     tags={"FoodData Central"},
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
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of food products from FoodData Central"
     *     )
     * )
     */
    public function search(string $query, int $page = 1)
    {
        $response = $this->client->request('GET', 'foods/search', [
            'query' => [
                'api_key'    => self::$apiKey,
                'query'      => $query,
                'pageSize'   => self::$pageSize,
                'pageNumber' => $page,
                'dataType'   => 'Branded',
            ],
        ]);

        $apiResult = json_decode($response->getBody()->getContents(), true);

        $products = collect($apiResult['foods'])->map(function ($apiFood) {
            $product = new Product([
                'api_id' => $apiFood['fdcId'] ?? null,
                'name'   => $apiFood['description'] ? strtolower($apiFood['description']) : null,
                'image'  => null,
                'brand'  => $apiFood['brandName'] ?? ($apiFood['brandOwner'] ?? null),
            ]);

            if (self::$enableGoogleImageApi) {
                $googleApiController = new GoogleApiController();
                $query = $product->brand ? "$product->brand $product->name" : $product->name;
                $googleImage = $googleApiController->getGoogleImage($query);
                $product->image = $googleImage;
            }

            return $product;
        });
        
        return response()->json([
            'products'  => $products,
            'pageCount' => $apiResult['totalPages'],
        ]);
    }

    /**
     * @OA\Get(
     *     path="/fdc/food/{id}",
     *     tags={"FoodData Central"},
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
        $response = $this->client->request('GET', "food/$id", [
            'query' => [
                'api_key' => self::$apiKey,
            ]
        ]);

        $apiFood = json_decode($response->getBody()->getContents(), true);

        $product = new Product([
            'api_id'            => $apiFood['fdcId'] ?? null,
            'name'              => $apiFood['description'] ? strtolower($apiFood['description']) : null,
            'image'             => null,
            'country'           => $apiFood['marketCountry'] ?? null,
            'brand'             => $apiFood['brandName'] ?? ($apiFood['brandOwner'] ?? null),
            'description'       => $apiFood['description'] ? strtolower($apiFood['description']) : null,
            'category'          => null,
            'tags'              => $apiFood['brandedFoodCategory'] ? str_replace(', ', ',', $apiFood['brandedFoodCategory']) : null,
            'ingredients'       => $apiFood['ingredients'] ? str_replace(', ', ',', rtrim(preg_replace('/\([^)]+\)/', '', $apiFood['ingredients']), '.')) : null,
            'serving_size_unit' => $apiFood['servingSizeUnit'] ? strtolower($apiFood['servingSizeUnit']) : null,
            'serving_size'      => $apiFood['servingSize'] ?? null,
            'calories'          => $apiFood['labelNutrients']['calories']['value'] ?? 0,
            'fat'               => $apiFood['labelNutrients']['fat']['value'] ?? 0,
            'carbohydrates'     => $apiFood['labelNutrients']['carbohydrates']['value'] ?? 0,
            'protein'           => $apiFood['labelNutrients']['protein']['value'] ?? 0,
        ]);

        if (self::$enableGoogleImageApi) {
            $googleApiController = new GoogleApiController();
            $query = $product->brand ? "$product->brand $product->name" : $product->name;
            $googleImage = $googleApiController->getGoogleImage($query);
            $product->image = $googleImage;
        }

        return response()->json($product);
    }
}
