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

    protected $fillable = ['listing_id', 'url', 'image_id', 'sort'];

    public function store($params)
    {
        $images = array_column($params, 'image_id', 'listing_id');

        $listings = self::whereIn('listing_id', array_keys($images))
        ->get();

        $create = $update = [];

        foreach ($params as $param) {
            $groups = $listings->where('listing_id', $param['listing_id']);
            foreach ($param['Images'] as $image) {
                // 判断当前位置是否存在图片
                if (in_array($groups->pluck('sort')->all(), $param['rank'])) {
                    $update[] = $this->filled($param);
                } else {
                    $create[] = $this->filled($param);
                }
            }
        }
        dd($create);

        if ($create) {
            self::insert($create);
        } 
        if ($update) {
            self::updateBatch($update);
        }
        return true;
    }

    protected function filled($params)
    {
        return [
            'listing_id' => $params['listing_id'],
            'image_id' => $params['listing_image_id'],
            'url' => $params['url_fullxfull'],
            'sort' => $params['rank']
        ];
    }
}
