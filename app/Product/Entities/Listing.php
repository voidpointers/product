<?php

namespace Product\Entities;

use App\Model;

class Listing extends Model
{
    protected $table = 'listings';

    protected $appends = ['state_str'];

    protected const STATE_STR = [
        'active' => '在线'
    ];

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

    public function images()
    {
        return $this->hasMany(Image::class, 'listing_id', 'listing_id');
    }

    public function store($shop_id, $params)
    {
        foreach ($params as $key => $param) {
            $param['tags'] = json_encode($param['tags']);
            $param['shop_id'] = $shop_id;
            $param['sku'] = json_encode($param['sku']);

            $data = [
                'image_id' => $param['Images'][0]['listing_image_id'],
                'image' => $param['Images'][0]['url_fullxfull'],
                'create_time' => time(),
                'update_time' => time(),
            ];
            foreach ($this->fillable as $fillable) {
                $data[$fillable] = $param[$fillable] ?? '';
            }
            Listing::updateOrCreate(['listing_id' => $param['listing_id']], $data);
        }

        return true;
    }

    public function storeBatch($shop_id, $params)
    {
        $update = $create = [];

        $listing_ids = self::whereIn('listing_id', array_column($params, 'listing_id'))->get()->keyBy('listing_id');

        foreach ($params as $param) {
            $param['tags'] = json_encode($param['tags']);
            $param['shop_id'] = $shop_id;
            $param['sku'] = json_encode($param['sku']);

            if (in_array($param['listing_id'], $listing_ids)) {
                $update[] = $this->filled($param);
            } else {
                $create[] = $this->filled($param);
            }
        }

        // 如果存在则更新
        if ($update) {
            $this->updateBatch($update, 'listing_id', 'listing_id');
        }
        if ($create) {
            $res = self::insert($create);
        }
        return $res;
    }

    protected function filled($params)
    {
        $data[$params['listing_id']] = [
            'image_id' => $params['MainImage']['listing_image_id'],
            'image' => $params['MainImage']['url_fullxfull'],
            'create_time' => time(),
            'update_time' => time(),
        ];
        foreach ($this->fillable as $fillable) {
            $data[$params['listing_id']][$fillable] = $params[$fillable] ?? '';
        }
        return $data;
    }

    public function getStateStrAttribute()
    {
        return self::STATE_STR[$this->attributes['state']] ?? '';
    }
}
