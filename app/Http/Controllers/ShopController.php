<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function ShopPage()
    {
        return view('shop');
    }
    public function SingleProductPage()
    {
        return view('single_product');
    }
}
