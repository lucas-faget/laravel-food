<?php

namespace App\Http\Controllers;

use App\Models\Product;
use GuzzleHttp\Client;

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

    public function food(string $id)
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

    public function foodSearch(string $searchQuery, int $pageNumber = 1)
    {
        $response = $this->client->request('GET', "search", [
            'query' => [
                'categories_tags_fr' => $searchQuery,
                'page_size' => self::$pageSize,
                'page' => $pageNumber,
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
}