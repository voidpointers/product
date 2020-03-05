<?php

namespace Product\Entities;

use App\Model;

class Property extends Model
{
    protected $table = 'listing_properties';

    /**
     * 创建时间
     */
    const CREATED_AT = null;

    /**
     * 更新时间
     */
    const UPDATED_AT = null;

    protected $fillable = [
        'listing_id',
        'category_path_ids',
        'category_path',
        'item_weight_unit',
        'item_weight',
        'item_length',
        'item_width',
        'item_height',
        'materials',
        'description'
    ];

    public function store($params)
    {
        foreach ($params as $key => $param) {
            $param['category_path_ids'] = json_encode('');
            $param['category_path'] = json_encode('');
            $param['materials'] = json_encode('');
            $param['item_weight'] = $param['item_length'] = $param['item_width'] = $param['item_height'] =  0;

            foreach ($this->fillable as $fillable) {
                $data[$fillable] = $param[$fillable] ?? '';
            }

            Property::updateOrCreate(['listing_id' => $param['listing_id']], $data);
        }

        return true;
    }
}
