<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;

class OpenProductController extends Controller
{
    protected $client;
    protected static $apiKey = "18ac2bcc8b3e452790f15c7468901108";
    protected static $pageSize = 12;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.spoonacular.com/food/',
            'verify' => false
        ]);
    }

    public function ingredientSearch(string $searchQuery, $pageNumber = 0)
    {
        $response = $this->client->request('GET', 'ingredients/search', [
            'query' => [
                'apiKey' => self::$apiKey,
                'query' => $searchQuery,
                'number' => self::$pageSize,
                'offset' => (self::$pageSize * $pageNumber)
            ],
        ]);
        
        $products = $response->getBody()->getContents();

        return $products;
    }

    public function ingredient(string $id)
    {
        $response = $this->client->request('GET', "ingredients/$id/information", [
            'query' => [
                'apiKey' => self::$apiKey,
                'amount' => 1
            ]
        ]);

        $product = $response->getBody()->getContents();

        return $product;
    }

    public function productSearch(string $searchQuery, $pageNumber = 0)
    {
        $response = $this->client->request('GET', 'products/search', [
            'query' => [
                'apiKey' => self::$apiKey,
                'query' => $searchQuery,
                'number' => self::$pageSize,
                'offset' => (self::$pageSize * $pageNumber)
            ],
        ]);
        
        $products = $response->getBody()->getContents();

        return $products;
    }

    public function product(string $id)
    {
        $response = $this->client->request('GET', "products/$id", [
            'query' => [
                'apiKey' => self::$apiKey,
                'amount' => 1
            ]
        ]);

        $product = $response->getBody()->getContents();

        return $product;
    }
}
