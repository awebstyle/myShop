<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Product;
use App\Models\Category;

class ProductsController extends Controller
{
    public function addProduct(){
        $categories = Category::all();
        return view('admin.addproduct')->with('categories', $categories);
    }

    public function saveProduct(Request $request){
        
        // validation des données, dont la taille de l'image
        $this->validate($request, [
            'product_name' => 'required',
            'product_price' => 'required',
            'product_category' => 'required',
            'product_description' => 'required',
            'product_image' => 'image|nullable|max:1999'
        ]);

        // on s'assure d'avoir un nom unique par image
        // on reprend le nom original de l'image avec son extension
        $fileNameWithExtension = $request->file('product_image')->getClientOriginalName();
        $fileName = pathinfo($fileNameWithExtension, PATHINFO_FILENAME);
        $extension = $request->file('product_image')->getClientOriginalExtension();
        $fileNameToStore = $fileName ."_".time() .".". $extension;
       
        // path pour le stockage du fichier image dans le dossier storage/app/public/slidersImages
        $path = $request->file('product_image')->storeAs("public/products-images", $fileNameToStore);

        $product = new Product();
        $product->product_name = $request->input('product_name');
        $product->product_description = $request->input('product_description');
        $product->product_price = $request->input('product_price');
        $product->product_category = $request->input('product_category');
        $product->product_image = $fileNameToStore;
        $product->save();
        return back()->with('status', 'le produit a été créé avec succès');
    }

    public function showProducts(){
        $products = Product::get();
        return view('admin.products')->with('products', $products);
    }

    public function deleteProduct($id){
        $product = Product::find($id);
        Storage::delete("public/products-images/$product->product_image");
        $product->delete();
        return back()->with("status", "Votre produit a été supprimé avec succès");
    }

    public function editProduct($id){
        $product = Product::find($id);
        $categories = Category::where('category_name', "!=", $product->product_category )->get();
        return view('admin.editProduct')->with('product', $product)->with('categories', $categories);
    }

    public function updateProduct($id, Request $request){
        $product = Product::find($id);
        $product->product_name = $request->input('product_name');
        $product->product_price = $request->input('product_price');
        $product->product_category = $request->input('product_category');
       
        if($request->file('product_image')){
            $this->validate($request, [
                'product_image' => 'image|nullable|max:1999'
            ]);
            
            // on s'assure d'avoir un nom unique par image
            // on reprend le nom original de l'image avec son extension
            $fileNameWithExtension = $request->file('product_image')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExtension, PATHINFO_FILENAME);
            $extension = $request->file('product_image')->getClientOriginalExtension();
            $fileNameToStore = $fileName ."_".time() .".". $extension;
        
            // on va supprimer l'image déjà dans la db
            Storage::delete("public/products-images/$product->image");

            // path pour le stockage du fichier image dans le dossier storage/app/public/slidersImages
            $path = $request->file('product_image')->storeAs("public/products-images", $fileNameToStore);
            $product->product_image = $fileNameToStore;
        }
       
        $product->update();
        return redirect('admin/products')->with('status', 'votre produit a été mis à jour avec succès');
    }

     public function unactivateProduct($id){
        $product = Product::find($id);
        $product->status = 0;
        $product->update();
        return back();
    }

    public function activateProduct($id){
        $product = Product::find($id);
        $product->status = 1;
        $product->update();
        return back();
    }

}
