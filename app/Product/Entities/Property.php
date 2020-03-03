<?php

namespace Product\Entities;

use App\Model;

class Property extends Model
{
    protected $table = 'listing_properties';

    /**
     * 创建时间
     */
    const CREATED_AT = 'create_time';

    /**
     * 更新时间
     */
    const UPDATED_AT = 'update_time';
}
