<?php

namespace Api\Product\V1\Controllers;

use Api\Product\V1\Transforms\CategoryTransformer;
use Api\Product\V1\Transforms\DetailTransformer;
use Api\Product\V1\Transforms\ListingTransformer;
use App\Controller;
use Dingo\Api\Http\Request;
use Etsy\Requests\ListingRequest;
use Product\Entities\Category;
use Product\Entities\Listing;

class ProductController extends Controller
{
    protected $listingRequest;
    
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

    public function update_title(Request $request)
    {
        $listing_id = $request->input('listing_id', 0);echo 33;exit;
        $title = $request->input('title', '');var_dump($title);exit;

        $result = Listing::where(['listing_id' => $listing_id])
        ->update(['title' => $title]);var_dump($result);exit;
    }
}
