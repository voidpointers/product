<?php

namespace Api\Product\V1\Transforms;

use League\Fractal\TransformerAbstract;
use Product\Entities\Image;

class ImageTransformer extends TransformerAbstract
{
    public function transform(Image $image)
    {
        return $image->attributesToArray();
    }
}
