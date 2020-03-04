<?php

namespace Api\Product\V1\Transforms;

use League\Fractal\TransformerAbstract;
use Product\Entities\Category;

class CategoryTransformer extends TransformerAbstract
{
    public function transform(Category $listing)
    {
        return $listing->attributesToArray();
    }
}
