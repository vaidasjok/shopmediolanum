<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\FrontendImage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use DB;

class FrontendImagesController extends Controller
{


    public function frontend_add_image(Request $request) 
    {
    	$images = FrontendImage::get();
        
        if($request->isMethod('post')) {

        	$title = $request->input('title');
	        $type = $request->input('type');
	        $link = $request->input('link');
            if(!empty($link)) {
                $link = $link;
            } else {
                $link = "";
            }

        	Validator::make($request->all(), ['image' => 'required|image|mimes:png,jpg,jpeg|max:2000'])->validate(); 
	        $ext = $request->file('image')->getClientOriginalExtension(); //jpg
	        $stringImageFormat = str_replace(' ', '', $request->input('title'));
	        $imageName = $stringImageFormat . '-' . time() . "." . $ext;

	        $imageEncoded = File::get($request->image);
	        Storage::disk('local')->put('public/frontend_images/' . $imageName, $imageEncoded);

	        $newImageArray = array('title' => $title, 'image' => $imageName, 'type' => $type, 'link' => $link ); 
	        $created = DB::table('frontend_images')->insert($newImageArray);

	        if($created) {
	            return redirect()->back()->withSuccess('Image successfuly added');
	        } else {
	            return redirect()->back()->withError('Problem adding image');
	        }
        }

        return view('admin.front.frontend_images', ['images' => $images]);

    }

    public function frontend_delete_image($id)
    {
    	$image = FrontendImage::findOrFail($id);
    	$exists = Storage::disk('local')->exists('public/frontend_images/' . $image->image);

        //delete old image
        if($exists) {
            Storage::delete('public/frontend_images/' . $image->image);
        }
    	$image->delete();

    	return redirect()->back()->withSuccess('Image deleted successfuly');
    }

    public function enableImage(Request $request, $id)
    {
    	
    	$enabled = $request->input('enabled');

        $image = FrontendImage::find($id);
        $image->enabled = (string) $enabled;
        $image->save();

        return 'ok';

    }



}
