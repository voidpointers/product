<?php

namespace Api\Product\V1\Controllers;

use Api\Product\V1\Transforms\ListingTransfomer;
use App\Controller;
use Product\Entities\Listing;

class ListingsController extends Controller
{
    public function index()
    {
        $data = Listing::where()->get();

        return $this->response->collection(
            $data,
            ListingTransfomer::class,
            'include'
        );
    }
}
