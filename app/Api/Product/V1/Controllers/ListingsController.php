<?php

namespace Api\Product\V1\Controllers;

use Api\Product\V1\Transforms\ListingTransfomer;
use App\Controller;
use Dingo\Api\Http\Request;
use Etsy\Requests\ListingRequest;
use Product\Entities\Listing;

class ListingsController extends Controller
{
    protected $listingRequest;

    public function __construct(ListingRequest $listingRequest)
    {
        $this->listingRequest = $listingRequest;
    }
    
    public function index($shop_id, Request $request)
    {
        $data = Listing::where(['shop_id' => $shop_id])->get();

        return $this->response->collection(
            $data,
            ListingTransfomer::class
        );
    }

    public function pull($shop_id, Request $request)
    {
        $request->offsetSet('shop_id', $shop_id);
        $data = $this->listingRequest->pull($request->all());
        dd($data);
    }
}
