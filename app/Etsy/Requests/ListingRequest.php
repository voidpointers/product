<?php

namespace Etsy\Requests;

use GuzzleHttp\Client;

class ListingRequest
{
    public function pull(array $params)
    {
        $shop_id = $params['shop_id'] ?? 0;
        $url = env('ETSY_URL') . "/listings/{$shop_id}";

        $client = new Client();

        $page = 1;
        // while ($page) {
            $response = $client->request('GET', $url, [
                'auth' => ['user', 'pass'],
                'query' => ['limit' => 25, 'page' => $page]
            ]);
            $body = $response->getBody();
        // }
        return $body;
    }
}
