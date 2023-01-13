<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Product;

class ClientController extends Controller
{
    public function home(){
        $sliders = Slider::get();
        $products = Product::get();
        return view ('client.home')->with('sliders', $sliders)->with('products', $products);
    }

    public function shop(){
        return view ('client.shop');
    }
}
