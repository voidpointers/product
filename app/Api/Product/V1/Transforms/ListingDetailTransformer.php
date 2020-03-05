<?php

namespace Api\Product\V1\Transforms;

use League\Fractal\TransformerAbstract;
use Product\Entities\Listing;

class ListingDetailTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['images', 'description'];

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

    public function includeDescription($listing)
    {
        return $this->collection(
            $listing->description ?? [],
            new ListingPropertiesTransformer,
            'include'
        );
    }
}
