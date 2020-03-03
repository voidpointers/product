<?php

namespace Product\Entities;

use App\Model;

class Listing extends Model
{
    protected $table = 'listings';

    protected $fillable = [
        'listing_id',
        'shop_id',
        'user_id',
        'category_id',
        'title',
        'price',
        'quantity',
        'sku',
        'tags',
        'url',
        'views',
        'num_favorers',
        'state',
        'is_customizable',
        'should_auto_renew',
        'creation_tsz',
        'ending_tsz',
        'last_modified_tsz'
    ];

    public function store($shop_id, $params)
    {
        $data = [];

        foreach ($params as $key => $param) {
            $param['tags'] = json_encode($param['tags']);
            $param['shop_id'] = $shop_id;
            $param['sku'] = json_encode($param['sku']);

            $data[$key] = [
                'image_id' => $param['MainImage']['listing_image_id'],
                'image' => $param['MainImage']['url_fullxfull'],
                'create_time' => time(),
                'update_time' => time(),
            ];

            foreach ($this->fillable as $fillable) {
                $data[$key][$fillable] = $param[$fillable] ?? '';
            }

        }

        return self::insert($data);
    }
}
