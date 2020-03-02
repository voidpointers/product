<?php

namespace Etsy\Requests;

use GuzzleHttp\Client;
use Product\Entities\Listing;

class ListingRequest
{
    public function pull(array $params)
    {
        $shop_id = $params['shop_id'] ?? 0;
        $url = env('ETSY_URL') . "/listings/{$shop_id}";

        $client = new Client();

        $page = 1;
        while ($page) {
            $response = $client->request('GET', $url, [
                'auth' => ['user', 'pass'],
                'query' => ['limit' => 25, 'page' => $page]
            ]);
            $body = json_decode($response->getBody()->getContents(), true);

            // 存储数据到MySQL
            $data = $body['results'];
            Listing::insert($data);

            // 最后一页为null，退出循环
            $page = $body->pagination->next_page;
        }
        return json_decode($body, true);
    }
}
