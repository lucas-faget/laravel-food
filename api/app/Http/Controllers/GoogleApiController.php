<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;

class GoogleApiController extends Controller
{
    protected $client;
    protected static $key;
    protected static $cx;

    public function __construct()
    {
        self::$key = env('GOOGLE_API_KEY');
        self::$cx = env('GOOGLE_API_CX');
        
        $this->client = new Client([
            'base_uri' => 'https://www.googleapis.com/customsearch/v1',
            'verify' => false,
        ]);

        header("Access-Control-Allow-Origin: http://localhost:5173");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Allow-Headers: Content-Type");
    }

    public function getGoogleImage(string $query)
    {
        $response = $this->client->request('GET', '', [
            'query' => [
                'key'        => self::$key,
                'cx'         => self::$cx,
                'q'          => $query,
                'searchType' => 'image',
            ],
        ]);

        $result = json_decode($response->getBody()->getContents(), true);

        return $result['items'][0]['link'];
    }
}
