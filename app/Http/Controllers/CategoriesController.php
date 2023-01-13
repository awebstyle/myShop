<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Category;

class CategoriesController extends Controller
{
    public function saveCategory(Request $request){

        // validation des données, dont la taille de l'image
        $this->validate($request, [
            'category_name' => 'required',
            'image' => 'image|nullable|max:1999'
        ]);

        // on s'assure d'avoir un nom unique par image
        // on reprend le nom original de l'image avec son extension
        $fileNameWithExtension = $request->file('image')->getClientOriginalName();
        $fileName = pathinfo($fileNameWithExtension, PATHINFO_FILENAME);
        $extension = $request->file('image')->getClientOriginalExtension();
        $fileNameToStore = $fileName ."_".time() .".". $extension;
       
        // path pour le stockage du fichier image dans le dossier storage/app/public/slidersImages
        $path = $request->file('image')->storeAs("public/categories-images", $fileNameToStore);

        $category = new Category();
        $category->category_name = $request->input('category_name');
        $category->image = $fileNameToStore;
        $category->save();
        return back()->with("status", "La catégorie a été créée avec succès");
    }

    public function showCategories(){
        $categories = Category::get();
        return view('admin.categories')->with('categories', $categories);
    }

    public function deleteCategory($id){
        $category = Category::find($id);
        Storage::delete("public/categories-images/$category->image");
        $category->delete();
        return back()->with("status", "Votre catégorie a été supprimée avec succès");
    }

    public function editCategory($id){
        $category = Category::find($id);
        return view('admin.editCategory')->with('category', $category);
    }

    public function updateCategory($id, Request $request){
        $category = Category::find($id);
        $category->category_name = $request->input('category_name');
        if($request->file('image')){
            $this->validate($request, [
                'image' => 'image|nullable|max:1999'
            ]);
            
            // on s'assure d'avoir un nom unique par image
            // on reprend le nom original de l'image avec son extension
            $fileNameWithExtension = $request->file('image')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExtension, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = $fileName ."_".time() .".". $extension;
        
            // on va supprimer l'image déjà dans la db
            Storage::delete("public/categories-images/$category->image");

            // path pour le stockage du fichier image dans le dossier storage/app/public/slidersImages
            $path = $request->file('image')->storeAs("public/categories-images", $fileNameToStore);
            $category->image = $fileNameToStore;
        }
        $category->update();
        return redirect('admin/categories')->with('status', 'votre catégorie a été mise à jour avec succès');
    }

   
}
