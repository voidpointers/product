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
        'image',
        'image_id',
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

    public function property()
    {
        return $this->hasOne(Property::class, 'listing_id', 'listing_id');
    }

    public function store($shop_id, $params)
    {
        foreach ($params as $key => $param) {
            $param['tags'] = json_encode($param['tags']);
            $param['shop_id'] = $shop_id;
            $param['sku'] = json_encode($param['sku']);

            foreach ($this->fillable as $fillable) {
                $data[$fillable] = $param[$fillable] ?? '';
            }
            $data['image_id'] = $param['Images'][0]['listing_image_id'];
            $data['image'] = $param['Images'][0]['url_fullxfull'];
            $data['create_time'] = time();
            $data['update_time'] = time();

            Listing::updateOrCreate(['listing_id' => $param['listing_id']], $data);
        }

        return true;
    }

    public function saveBatch($shop_id, $params)
    {
        $update = $create = [];

        $listing_ids = self::whereIn('listing_id', array_column($params, 'listing_id'))
        ->pluck('listing_id');

        foreach ($params as $key => $param) {
            $param['shop_id'] = $shop_id;

            if (in_array($param['listing_id'], $listing_ids)) {
                $update[] = $this->filled($param);
            } else {
                $create[$key] = $this->filled($param);
                $create[$key]['create_time'] = time();
            }
        }

        // 如果存在则更新
        if ($update) {
            $res = $this->updateBatch($update, 'listing_id', 'listing_id');
        }
        if ($create) {
            $res = self::insert($create);
        }
        return $res;
    }

    protected function filled($params)
    {
        $data = [
            'update_time' => time()
        ];
        foreach ($params as $key => $param) {
            if (in_array($key, $this->fillable)) {
                $data[$key] = $param;
            }
            if ($images = $param['Images'] ?? []) {
                $data['image_id'] = $images[0]['listing_image_id'];
                $data['image'] = $images[0]['url_fullxfull'];
            }
            if (array_key_exists('tags', $data)) {
                $data['tags'] = json_encode($param['tags']);
            }
        }

        return $data;
    }

    public function getStateStrAttribute()
    {
        return self::STATE_STR[$this->attributes['state']] ?? '';
    }
}
