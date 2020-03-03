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

    public function store($params)
    {
        $data = [];
        foreach ($params as $key => $param) {
            foreach ($this->fillable as $fillable) {
                $data[$key][$fillable] = $param[$fillable] ?? '';
            }
            $data[$key]['image_id'] = $param['MainImage']['listing_image_id'];
            $data[$key]['image'] = $param['MainImage']['url_fullxfull'];
        }

        dd($data);
    }
}
