<?php

namespace App\Http\Controllers;

use App\Models\Product;
use GuzzleHttp\Client;

class SpoonacularApiController extends Controller
{
    protected $client;
    protected static $apiKey;
    protected static $pageSize = 12;

    protected static $calories = "Calories";
    protected static $fat = "Fat";
    protected static $carbohydrates = "Carbohydrates";
    protected static $protein = "Protein";

    public function __construct()
    {
        self::$apiKey = env('API_KEY');
        
        $this->client = new Client([
            'base_uri' => 'https://api.spoonacular.com/food/',
            'verify' => false
        ]);

        header("Access-Control-Allow-Origin: http://localhost:5173");
        header("Access-Control-Allow-Methods: GET, POST");
        header("Access-Control-Allow-Headers: Content-Type");
    }

    public function ingredientSearch(string $searchQuery, $pageNumber = 1)
    {
        $response = $this->client->request('GET', 'ingredients/search', [
            'query' => [
                'apiKey' => self::$apiKey,
                'query' => $searchQuery,
                'number' => self::$pageSize,
                'offset' => self::$pageSize*($pageNumber-1)
            ],
        ]);

        $apiProducts = json_decode($response->getBody()->getContents(), true);

        $products = collect($apiProducts['results'])->map(function ($apiProduct) {
            return new Product([
                'api_id' => $apiProduct['id'] ?? null,
                'name' => $apiProduct['name'] ?? null,
                'image' => $apiProduct['image'] ?? null,
            ]);
        });
        
        return response()->json([
            'products' => $products,
            'totalResults' => $apiProducts['totalResults']
        ]);
    }

    public function ingredient(string $id)
    {
        $response = $this->client->request('GET', "ingredients/$id/information", [
            'query' => [
                'apiKey' => self::$apiKey,
                'amount' => 1
            ]
        ]);

        $apiProduct = json_decode($response->getBody()->getContents(), true);

        $product = new Product([
            'api_id' => $apiProduct['id'] ?? null,
            'name' => $apiProduct['name'] ?? null,
            'image' => $apiProduct['image'] ?? null,
            'category' => $apiProduct['aisle'] ?? null,
            'tags' => $apiProduct['categoryPath'] ? implode(',', $apiProduct['categoryPath']) : null,
            'calories' => null,
            'fat' => null,
            'carbohydrates' => null,
            'protein' => null
        ]);

        foreach($apiProduct['nutrition']['nutrients'] as $nutrient) {
            switch ($nutrient['name']) {
                case self::$calories:
                    $product->calories = $nutrient['amount'];
                    break;
                case self::$fat:
                    $product->fat = $nutrient['amount'];
                    break;
                case self::$carbohydrates:
                    $product->carbohydrates = $nutrient['amount'];
                    break;
                case self::$protein:
                    $product->protein = $nutrient['amount'];
                    break;
            }
        }

        return response()->json($product);
    }

    public function productSearch(string $searchQuery, $pageNumber = 1)
    {
        $response = $this->client->request('GET', 'products/search', [
            'query' => [
                'apiKey' => self::$apiKey,
                'query' => $searchQuery,
                'number' => self::$pageSize,
                'offset' => self::$pageSize*($pageNumber-1)
            ],
        ]);
        
        $apiProducts = json_decode($response->getBody()->getContents(), true);

        $products = collect($apiProducts['products'])->map(function ($apiProduct) {
            return new Product([
                'api_id' => $apiProduct['id'] ?? null,
                'name' => $apiProduct['title'] ?? null,
                'image' => $apiProduct['image'] ?? null,
            ]);
        });
        
        return response()->json([
            'products' => $products,
            'totalResults' => $apiProducts['totalProducts']
        ]);
    }

    public function product(string $id)
    {
        $response = $this->client->request('GET', "products/$id", [
            'query' => [
                'apiKey' => self::$apiKey,
                'amount' => 1
            ]
        ]);

        $apiProduct = json_decode($response->getBody()->getContents(), true);

        $product = new Product([
            'api_id' => $apiProduct['id'] ?? null,
            'name' => $apiProduct['title'] ?? null,
            'image' => $apiProduct['image'] ?? null,
            'brand' => $apiProduct['brand'] ?? null,
            'category' => $apiProduct['aisle'] ?? null,
            'tags' => $apiProduct['breadcrumbs'] ? implode(',', $apiProduct['breadcrumbs']) : null,
            'calories' => null,
            'fat' => null,
            'carbohydrates' => null,
            'protein' => null,
            'ingredients' => $apiProduct['ingredientList'] ?? null
        ]);

        foreach($apiProduct['nutrition']['nutrients'] as $nutrient) {
            switch ($nutrient['name']) {
                case self::$calories:
                    $product->calories = $nutrient['amount'];
                    break;
                case self::$fat:
                    $product->fat = $nutrient['amount'];
                    break;
                case self::$carbohydrates:
                    $product->carbohydrates = $nutrient['amount'];
                    break;
                case self::$protein:
                    $product->protein = $nutrient['amount'];
                    break;
            }
        }

        return response()->json($product);
    }
}
