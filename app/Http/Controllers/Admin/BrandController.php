<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use App\Brand;

class BrandController extends Controller
{
    public function add_brand(Request $request)
    {
    	$locale = App::getLocale();
    	if($request->isMethod('post')) {
    		
    		$name = $request->input('brand_name');
    		$description = $request->input('brand_description');

    		$brand = new Brand;
    		$brand->name = $name;
    		$brand->description = $description;
    		$brand->save();
    	}

    	$brands = Brand::get();

    	return view('admin.brands.add_brand', ['brands' => $brands]);
    }

    public function delete_brand($id)
    {
    	Brand::findOrFail($id)->delete();

    	return redirect()->back()->withSuccess('Brand deleted successfully');
    }

    public function edit_brand(Request $request, $id)
    {
    	$brand = Brand::findOrFail($id);
    	if($request->isMethod('post')) {
    		
    		$name = $request->input('brand_name');
    		$description = $request->input('brand_description');

    		$brand = Brand::findOrFail($id);
    		$brand->name = $name;
    		$brand->description = $description;
    		$brand->save();

    		return redirect()->back()->withSuccess('Brand successfully edited.');
    	}

    	return view('admin.brands.edit_brand', ['brand' => $brand]);
    }
}
