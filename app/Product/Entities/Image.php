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

    protected $fillable = ['listing_id', 'url', 'image_id'];

    public function store($shop_id, $params)
    {
        foreach ($params as $key => $param) {
            foreach ($param['Images'] as $image) {
                $data = [
                    'image_id' => $image['listing_image_id'],
                    'image' => $image['url_fullxfull'],
                    'listing_id' => $param['listing_id'],
                ];
                Image::updateOrCreate(['listing_id' => $param['listing_id']], $data);
            }
        }

        return true;
    }
}
