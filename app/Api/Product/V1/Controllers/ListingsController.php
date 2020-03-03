<?php

namespace Api\Product\V1\Controllers;

use Api\Product\V1\Transforms\ListingTransformer;
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
    
    public function index(Request $request)
    {
        $shop_id = $request->header('shop-id');

        $data = Listing::where(['shop_id' => $shop_id])
        ->orderBy('id', 'desc')
        ->paginate($request->get('limit', 30));

        return $this->response->paginator(
            $data,
            ListingTransformer::class
        );
    }

    public function pull(Request $request)
    {
        $data = $this->listingRequest->pull($request->all());
    }

    public function detail(Request $request)
    {
        $shop_id = $request->header('shop-id');
        $listing_ids = $request->input('listing_ids');

        $data = Listing::where(['shop_id' => $shop_id])
        ->whereIn('listing_id', explode(',', $listing_ids))
        ->get();

        return $this->response->collection(
            $data,
            ListingTransformer::class
        );
    }
}
