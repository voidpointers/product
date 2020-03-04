<?php

namespace Etsy\Requests;

use GuzzleHttp\Client;
use Product\Entities\Category;
use Product\Entities\Listing;
use Product\Entities\ListingImage;

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
            (new Listing)->store($shop_id, $data);
            (new ListingImage)->store($shop_id, $data);

            echo "当前处理页数: " . $page . PHP_EOL;
            // 最后一页为null，退出循环
            $page = $body['pagination']['next_page'];
        }
        return true;
    }

    public function get_category($parent_id = 0)
    {
        $urls = ['http://api.createos.xyz/etsy/category/top', 'http://api.createos.xyz/etsy/category/sub?tag=', 'http://api.createos.xyz/etsy/category/3rd?tag='];
        if (isset($urls[$parent_id])) {
            $client = new Client();
            $response = $client->request('GET', $urls[$parent_id], []);
            $body = json_decode($response->getBody()->getContents(), true);
            $categories_st = $body['results'];
            (new Category)->store($categories_st, $parent_id);
            if (isset($urls[$parent_id + 1])) {
                foreach ($categories_st as $first_c) {
                    $response = $client->request('GET', $urls[$parent_id + 1] . $first_c['short_name'], []);
                    $body = json_decode($response->getBody()->getContents(), true);
                    $categories_nd = $body['results'];
                    (new Category)->store($categories_nd, $first_c['category_id']);
                    if (isset($urls[$parent_id + 2])) {
                        foreach ($categories_nd as $second_c) {
                            $response = $client->request('GET', $urls[$parent_id + 2] . $first_c['short_name'] . '&subtag=' . $second_c['short_name'], []);
                            $body = json_decode($response->getBody()->getContents(), true);
                            $categories_rd = $body['results'];
                            (new Category)->store($categories_rd, $second_c['category_id']);
                        }
                    }
                }
            }
        }
    }
}
