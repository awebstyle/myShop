<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use App\Models\Client;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

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

    public function addToCart($id){
        $product = Product::find($id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product);
        Session::put('cart', $cart);
        Session::put('topCart', $cart->items);

        return back();
    }

    public function updateQty(Request $request, $id){
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->updateQty($id, $request->qty);
        Session::put('cart', $cart);
        Session::put('topCart', $cart->items);

        return back();
    }

    public function removeProduct($id){
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $cart->removeItem($id);

        Session::put('cart', $cart);
        Session::put('topCart', $cart->items);

        return back();
    }

    public function checkout(){
        if(Session::has('client')){
            return view('client.checkout');
        }
        else return redirect ('/signin');
    }

    public function createAccount(Request $request){
        
        $this->validate($request, [
            'email' => 'email|required|unique:clients',
            'password' => 'required|min:8'
        ]);

        $client = new Client();
        $client->email = $request->input('email');
        $client->password = bcrypt($request->input('password'));
        $client->save();

        return back()->with('status', 'Votre compte a été créé avec succès');

    }

    public function accessAccount(Request $request){
        $this->validate($request, [
            'email' =>'email|required'
        ]);

        $client = Client::where('email', $request->email)->first();
        if($client){
            if(Hash::check($request->input('password'), $client->password)){
                Session::put('client', $client);
                return redirect('/shop');
            }
            return back()->with('error', 'wrong email or password');
        }

        return back()->with('error', 'no account with that email');
    }

    public function logout(){
        Session::forget('client');
        return back();
    }
}
