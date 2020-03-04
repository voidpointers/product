<?php

namespace Product\Entities;

use App\Model;

class ListingImage extends Model
{
    protected $table = 'listing_images';

    protected $fillable = [
        'listing_id',
        'image_id',
        'image',
    ];

    public function store($shop_id, $params)
    {
        foreach ($params as $key => $param) {
            foreach ($param['Images'] as $image) {
                $data = [
                    'image_id' => $image['listing_image_id'],
                    'image' => $image['url_fullxfull'],
                    'listing_id' => $param['listing_id'],
                ];
                ListingImage::updateOrCreate(['listing_id' => $param['listing_id']], $data);
            }
        }

        return true;
    }
}
