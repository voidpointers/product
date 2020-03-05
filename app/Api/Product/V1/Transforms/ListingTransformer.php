<?php

namespace Api\Product\V1\Transforms;

use League\Fractal\TransformerAbstract;
use Product\Entities\Listing;

class ListingTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['description'];

    public function transform(Listing $listing)
    {
        return $listing->attributesToArray();
    }

    public function includeDescription($listing)
    {
        return $this->collection(
            $listing->description ?? [],
            new PropertiesTransformer(),
            'include'
        );
    }
}
