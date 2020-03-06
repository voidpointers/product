<?php

namespace Api\Product\V1\Controllers;

use App\Controller;
use Dingo\Api\Http\Request;
use Product\Entities\Listing;
use Product\Entities\Property;

class ProductController extends Controller
{
    public function update_title(Request $request)
    {
        $listing_id = $request->input('listing_id', 0);
        $title = $request->input('title', '');

        $res = Listing::where(['listing_id' => $listing_id])
        ->update(['title' => $title]);
        $result['code'] = $res == 1 ? 200 : 400;
        $result['data'] = [];
        $result['msg'] = $res == 1 ? '操作成功' : '操作失败';

        return response()->json($result);
    }

    public function update_desc(Request $request)
    {
        $listing_id = $request->input('listing_id', 0);
        $description = $request->input('description', '');

        $res = Property::where(['listing_id' => $listing_id])
            ->update(['description' => $description]);
        $result['code'] = $res == 1 ? 200 : 400;
        $result['data'] = [];
        $result['msg'] = $res == 1 ? '操作成功' : '操作失败';

        return response()->json($result);
    }

    public function update_tags(Request $request)
    {
        $listing_id = $request->input('listing_id', 0);
        $tags = $request->input('tags', '');

        $res = Listing::where(['listing_id' => $listing_id])
            ->update(['description' => $tags]);
        $result['code'] = $res == 1 ? 200 : 400;
        $result['data'] = [];
        $result['msg'] = $res == 1 ? '操作成功' : '操作失败';

        return response()->json($result);
    }

    public function update_materials(Request $request)
    {
        $listing_id = $request->input('listing_id', 0);
        $materials = $request->input('materials', '');

        $res = Listing::where(['listing_id' => $listing_id])
            ->update(['materials' => $materials]);
        $result['code'] = $res == 1 ? 200 : 400;
        $result['data'] = [];
        $result['msg'] = $res == 1 ? '操作成功' : '操作失败';

        return response()->json($result);
    }
}
