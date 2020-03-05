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
        ->with(['description'])
        ->orderBy('id', 'desc')
        ->paginate($request->get('limit', 30));

        return $this->response->paginator(
            $data,
            ListingTransformer::class
        );
    }

    public function pull(Request $request)
    {
        $shop_id = $request->header('shop-id');

        $data = $this->listingRequest->pull($shop_id);
    }

    public function detail(Request $request)
    {
        $shop_id = $request->header('shop-id');
        $listing_ids = $request->input('listing_ids');

        $data = Listing::where(['shop_id' => $shop_id])
        ->whereIn('listing_id', explode(',', $listing_ids))
        ->with(['images', 'property'])
        ->get();

        return $this->response->collection(
            $data,
            DetailTransformer::class
        );
    }

    public function category(Request $request)
    {
        $parent_id = $request->input('parent_id');

        $data = Category::where(['parent_id' => $parent_id])
            ->orderBy('category_id', 'desc')
            ->paginate($request->get('limit', 30));
        if ($data->total() == 0) {
            set_time_limit(0);
            $this->listingRequest->get_category($parent_id);
            $data = Category::where(['parent_id' => $parent_id])
                ->orderBy('category_id', 'desc')
                ->paginate($request->get('limit', 30));
        }

        return $this->response->paginator(
            $data,
            CategoryTransformer::class
        );
    }
}
