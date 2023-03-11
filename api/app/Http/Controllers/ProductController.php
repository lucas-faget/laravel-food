<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use GuzzleHttp\Client;

class ProductController extends Controller
{
    protected static $pageSize = 20;

    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://world.openfoodfacts.org/api/v2/',
            'verify' => false
        ]);
    }

    public function index($page = 1)
    {
        $response = $this->client->request('GET', 'search', [
            'query' => [
                'page_size' => self::$pageSize,
                'page' => $page,
            ],
        ]);
        
        $products = $response->getBody()->getContents();

        return $products;
    }

    public function show(string $code)
    {
        $response = $this->client->request('GET', "product/$code");

        $product = $response->getBody()->getContents();

        return $product;
    }

    public function search(string $search)
    {
        // TODO
    }
}
