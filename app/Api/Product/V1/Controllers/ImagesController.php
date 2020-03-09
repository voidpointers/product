<?php

namespace Api\Product\V1\Controllers;

use App\Controller;
use Dingo\Api\Http\Request;
use Product\Entities\Image;
use Product\Entities\Listing;

class ImagesController extends Controller
{
    protected $fillable = ['id', 'listing_id', 'url', 'image_id', 'sort'];

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
        $params = $request->json();

        $data = [];
        foreach ($params as $param) {
            if (array_diff(array_keys($param), $this->fillable)) {
                return $this->response->error('参数错误', 501);
            }
            if (1 == $param['sort'] ?? 1) {
                $data[] = [
                    'listing_id' => $param['listing_id'],
                    'image' => $param['url'],
                ];
            }
        }

        $model = new Image;
        $model->saveById($params->all());

        if ($data) {
            Listing::updateBatch($data, 'listing_id', 'listing_id');
        }

        return $this->response->array(['msg' => 'success']);
    }
}
