<?php

namespace Product\Entities;

use App\Model;

class Listing extends Model
{
    protected $table = 'listings';

    protected $fillable = [
        'listing_id',
        // 'shop_id',
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
            $param['sku'] = json_encode($param['sku']);
            $param['tags'] = json_encode($param['tags']);
            $param['shop_id'] = $shop_id;
            foreach ($this->fillable as $fillable) {
                $data[$key][$fillable] = $param[$fillable] ?? '';
            }
            $data[$key]['image_id'] = $param['MainImage']['listing_image_id'];
            $data[$key]['image'] = $param['MainImage']['url_fullxfull'];
        }

        return self::insert($data);
    }
}
