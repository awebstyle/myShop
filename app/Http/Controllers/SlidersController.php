<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Slider;
use Illuminate\Support\Facades\Storage;

class SlidersController extends Controller
{
    public function saveSlider(Request $request){
        
        // validation des données, dont la taille de l'image
        $this->validate($request, [
            'description1' => 'required',
            'description2' => 'required',
            'image' => 'image|nullable|max:1999'
        ]);

        // on s'assure d'avoir un nom unique par image
        // on reprend le nom original de l'image avec son extension
        $fileNameWithExtension = $request->file('image')->getClientOriginalName();
        $fileName = pathinfo($fileNameWithExtension, PATHINFO_FILENAME);
        $extension = $request->file('image')->getClientOriginalExtension();
        $fileNameToStore = $fileName ."_".time() .".". $extension;
       
        // path pour le stockage du fichier image dans le dossier storage/app/public/slidersImages
        $path = $request->file('image')->storeAs("public/sliders-images", $fileNameToStore);

        $slider = new Slider();
        $slider->description1 = $request->input('description1');
        $slider->description2 = $request->input('description2');
        $slider->image = $fileNameToStore;
        $slider->save();
        return back()->with('status', 'le slider a été créé avec succès');
    }

    public function showSliders(){
        $sliders = Slider::get();
        return view('admin.sliders')->with('sliders', $sliders);
    }

    public function deleteSlider($id){
        $slider = Slider::find($id);
        Storage::delete("public/sliders-images/$slider->image");
        $slider->delete();
        return back()->with("status", "Votre slider a été supprimé avec succès");
    }

    public function editSlider($id){
        $slider = Slider::find($id);
        return view('admin.editSlider')->with('slider', $slider);
    }

    public function updateSlider($id, Request $request){
        $slider = Slider::find($id);
        $slider->description1 = $request->input('description1');
        $slider->description2 = $request->input('description2');
       
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
            Storage::delete("public/sliders-images/$slider->image");

            // path pour le stockage du fichier image dans le dossier storage/app/public/slidersImages
            $path = $request->file('image')->storeAs("public/sliders-images", $fileNameToStore);
            $slider->image = $fileNameToStore;
        }
       
        $slider->update();
        return redirect('admin/sliders')->with('status', 'votre slider a été mis à jour avec succès');
    }

    public function unactivateSlider($id){
        $slider = Slider::find($id);
        $slider->status = 0;
        $slider->update();
        return back();
    }

    public function activateSlider($id){
        $slider = Slider::find($id);
        $slider->status = 1;
        $slider->update();
        return back();
    }
}
