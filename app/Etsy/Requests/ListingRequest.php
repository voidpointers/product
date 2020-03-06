<?php

namespace Etsy\Requests;

use GuzzleHttp\Client;
use Product\Entities\Category;
use Product\Entities\Listing;

class ListingRequest
{
    public function pull($shop_id)
    {
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
            (new Listing)->saveBatch($shop_id, $data);

            echo "当前处理页数: " . $page . PHP_EOL;
            // 最后一页为null，退出循环
            $page = $body['pagination']['next_page'];
        }
        return true;
    }
}
