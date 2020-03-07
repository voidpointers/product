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
        $listings = self::whereIn('listing_id', array_column($params, 'listing_id'))
        ->get();

        $create = $update = [];

        foreach ($params as $param) {
            $groups = $listings->where('listing_id', $param['listing_id']);
            foreach ($param['Images'] as $key => $image) {
                // 判断当前位置是否存在图片
                $sorts = $groups->pluck('id', 'sort')->all();

                if (in_array($image['rank'], $sorts)) {
                    $update[$key] = $this->filled($image);
                    $update[$key]['id'] = $sorts[$image['rank']];
                } else {
                    $create[] = $this->filled($image);
                }
            }
        }

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
