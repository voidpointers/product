<?php

namespace Api\Product\V1\Controllers;

use App\Controller;
use Dingo\Api\Http\Request;
use Product\Entities\Image;
use Product\Entities\Listing;

class ImagesController extends Controller
{
    public function __construct()
    {
    }
    
    public function index(Request $request)
    {
        $shop_id = $request->header('shop-id');
    }

    public function update(Request $request)
    {
        $shop_id = $request->header('shop-id');
        $params = $request->json()->all();

        $data = [];
        foreach ($params as $param) {
            if (1 == ($param['sort'] ?? 1)) {
                // 排序第一位需要更新主图
                $data[] = [
                    'listing_id' => $param['listing_id'],
                    'sort' => $param['sort'],
                    'image' => $param['url'],
                ];
            }
        }

        (new Image)->saveBySort($params);

        if ($data) {
            Listing::updateBatch($data, 'listing_id', 'listing_id');
        }

        return $this->response->array(['msg' => 'success']);
    }
}
