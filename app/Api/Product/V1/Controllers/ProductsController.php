<?php

namespace Api\Product\V1\Controllers;

use App\Controller;

class ProductsController extends Controller
{
    public function index()
    {
        return $this->response->array(['test']);
    }
}
