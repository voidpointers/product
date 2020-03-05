<?php

namespace Api\Product\V1\Transforms;

use League\Fractal\TransformerAbstract;

class PropertiesTransformer extends TransformerAbstract
{
    public function transform($property)
    {
        return $property->attributesToArray();
    }
}
