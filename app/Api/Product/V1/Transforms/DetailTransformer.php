<?php

namespace Api\Product\V1\Transforms;

use League\Fractal\TransformerAbstract;
use Product\Entities\Listing;

class DetailTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['images'];

    public function transform(Listing $listing)
    {
        return $listing->attributesToArray();
    }

    public function includeImages($listing)
    {
        return $this->collection(
            $listing->images ?? [],
            new ImageTransformer,
            'include'
        );
    }
}
