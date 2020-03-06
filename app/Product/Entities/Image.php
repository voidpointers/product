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

    public function store($params)
    {
        $images = array_column($params, 'image_id', 'listing_id');

        foreach ($params as $param) {
        }

        $listings = self::whereIn('listing_id', array_keys($images))
        ->get();

        foreach ($listings as $listing) {
            if ($listing->image_id) {
            }
        }

        $data = [];
        foreach ($params as $param) {
            $data[] = [
                'listing_id' => $param['listing_id'],
                'image_id' => $param['listing_image_id'],
                'url' => $param['url_fullxfull'],
                'order' => $param['rank']
            ];
        }

        Image::updateOrCreate(['listing_id' => $param['listing_id']], $data);
        return true;
    }
}
