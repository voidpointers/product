<?php

namespace Api\Product\V1\Controllers;

use Api\Product\V1\Transforms\ListingTransfomer;
use App\Controller;
use Dingo\Api\Http\Request;
use Product\Entities\Listing;

class ListingsController extends Controller
{
    public function index($shop_id, Request $request)
    {
        $data = Listing::where(['shop_id' => $shop_id])->get();

        return $this->response->collection(
            $data,
            ListingTransfomer::class
        );
    }
}
