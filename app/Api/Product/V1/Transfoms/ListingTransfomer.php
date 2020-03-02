<?php

namespace Api\Product\V1\Transforms;

use League\Fractal\TransformerAbstract;
use Product\Entities\Listing;

class ListingTransfomer extends TransformerAbstract
{
    public function tranform(Listing $listing)
    {
        return $listing->attributesToArray();
    }
}
