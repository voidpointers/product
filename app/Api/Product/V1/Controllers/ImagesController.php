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
        $params = $request->json()->all();

        $images = Image::whereIn('id', array_column($params, 'id'))
        ->get()
        ->keyBy('id');

        $data = [];
        foreach ($params as $param) {
            if (array_diff(array_keys($param), $this->fillable)) {
                return $this->response->error('参数错误', 501);
            }
            // 校验图片ID是否属于Lising
            if (array_key_exists('id', $param)) {
                $image = $images[$param['id']] ?? [];
                if (!$image) {
                    return $this->response->error("{$param['id']} 图片ID不匹配", 500);
                }
                if ($param['listing_id'] != $image->listing_id) {
                    return $this->response->error("{$param['id']} Lising ID错误", 501);
                }
            }
            // 需要更新主图
            if (1 == ($param['sort'] ?? 1)) {
                $data[] = [
                    'listing_id' => $param['listing_id'],
                    'image' => $param['url'],
                ];
            }
        }

        $model = new Image;
        $model->saveById($params);

        if ($data) {
            Listing::updateBatch($data, 'listing_id', 'listing_id');
        }

        return $this->response->array(['msg' => 'success']);
    }
}
