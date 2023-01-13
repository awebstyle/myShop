<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Product;
use App\Models\Category;

class ClientController extends Controller
{
    public function home(){
        $sliders = Slider::where('status', 1)->get();
        $products = Product::where('status', 1)->get();
        $categories = Category::get();
        return view ('client.home')->with('sliders', $sliders)->with('products', $products)->with('categories', $categories);
    }

    public function shop(){
        $products = Product::where('status', 1)->get();
        return view ('client.shop')->with('products', $products);
    }
}
