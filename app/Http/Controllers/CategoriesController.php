<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;

class CategoriesController extends Controller
{
    public function saveCategory(Request $request){
        $category = new Category();
        $category->category_name = $request->input('category_name');
        $category->save();
        return back()->with("status", "La catégorie a été créée avec succès");
    }

    public function showCategories(){
        $categories = Category::get();
        return view('admin.categories')->with('categories', $categories);
    }

    public function deleteCategory($id){
        $category = Category::find($id);
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
        $category->update();
        return redirect('admin/categories')->with('status', 'votre catégorie a été mise à jour avec succès');
    }

   
}
