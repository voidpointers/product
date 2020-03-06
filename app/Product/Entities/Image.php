<?php

namespace Product\Entities;

use App\Model;

class Image extends Model
{
    protected $table = 'listing_images';

    /**
     * 创建时间
     */
    const CREATED_AT = null;

    /**
     * 更新时间
     */
    const UPDATED_AT = null;

    protected $fillable = ['listing_id', 'url', 'image_id', 'order'];

    public function store($params)
    {
        $images = array_column($params, 'image_id', 'listing_id');

        $listings = self::whereIn('listing_id', array_keys($images))
        ->get();

        $data = [];

        foreach ($params as $param) {
            // 判断该商品是否有图片
            if (in_array($param['listing_id'], $listings->pluck('listing_id'))) {
                // 获取图片位置
                $groups = array_map(function ($item) use ($param) {
                    if ($param['listing_id'] == $item['listing_id']) {
                        return [$item['order'] => $item['id']];
                    }
                }, $listings);
                $data[] = $this->filled($param['Images'], $groups);
            } else {
                $data[] = $this->filled($param['Images']);
            }
        }

        if ($data['create']) {
            self::insert($data['create']);
        } 
        if ($data['update']) {
            self::updateBatch($data['update']);
        }
        return true;
    }

    protected function filled($params, $groups = [])
    {
        $data = [];
        foreach ($params as $key => $param) {
            $temp = [
                'listing_id' => $param['listing_id'],
                'image_id' => $param['listing_image_id'],
                'url' => $param['url_fullxfull'],
                'order' => $param['rank']
            ];
            if ($groups) {
                if (in_array($param['rank'], $groups)) {
                    $data['update'][$key] = $temp;
                    $data['update'][$key]['id'] = $groups[$param['rank']];
                } else {
                    $data['create'][] = $temp;
                }
            } else {
                $data['create'][] = $temp;
            }
        }
        return $data;
    }
}
