<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;

class OpenProductController extends Controller
{
    protected static $pageSize = 12;

    protected static $fields = "code,product_name,brands,image_url";

    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://fr.openfoodfacts.org/api/v2/',
            'verify' => false
        ]);
    }

    public function index(int $page = 1)
    {
        $response = $this->client->request('GET', 'search', [
            'query' => [
                'page_size' => self::$pageSize,
                'page' => $page,
                'fields' => self::$fields
            ],
        ]);
        
        $products = $response->getBody()->getContents();

        return $products;
    }

    public function show(string $barcode)
    {
        $response = $this->client->request('GET', "product/$barcode", [
            'query' => [
                'fields' => self::$fields
            ]
        ]);

        $product = $response->getBody()->getContents();

        return $product;
    }

    public function search(string $search, int $page = 1)
    {
        $response = $this->client->request('GET', "search", [
            'query' => [
                'categories_tags_fr' => $search,
                'page_size' => self::$pageSize,
                'page' => $page,
                'fields' => self::$fields
            ]
        ]);

        $product = $response->getBody()->getContents();

        return $product;
    }
}
