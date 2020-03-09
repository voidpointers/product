<?php

namespace Api\Product\V1\Controllers;

use App\Controller;
use Dingo\Api\Http\Request;
use Product\Entities\Image;

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
        $params = $request->json();

        foreach ($params as $param) {
            if (1 > $param['id'] ?? 0) {
                continue;
            }
            if (array_diff(array_keys($param), $this->fillable)) {
                return $this->response->error('参数错误', 500);
            }
        }

        (new Image())->updateById($params->all());

        return $this->response->array(['msg' => 'success']);
    }
}
