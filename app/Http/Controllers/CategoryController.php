<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Category;
use \App\WomenCategory;
use \App\Type;

class CategoryController extends Controller
{
    public function addCategory(Request $request)
    {
    	if($request->isMethod('post')) {
    		$data = $request->all();
    		// echo '<pre>'; print_r($data); die;
    		$category = new Category;
    		$category->name = $request->input('category_name');
    		$category->description = $request->input('description');
    		$category->url = $request->input('url');
    		$category->parent_id = $request->input('parent_id');
    		$category->save();
    		return redirect('admin/view-categories')->with('success', 'Category Added Successfully!');
    	}
    	$levels = Category::where('parent_id', 0)->get();
    	return view('admin.categories.add_category')->with('levels', $levels);
    }

    public function addWomenCategory(Request $request)
    {
        if($request->isMethod('post')) {
            $data = $request->all();
            // echo '<pre>'; print_r($data); die;
            $category = new WomenCategory;
            $category->name = $request->input('category_name');
            $category->description = $request->input('description');
            $category->url = $request->input('url');
            $category->parent_id = $request->input('parent_id');
            $category->save();
            return redirect('admin/view-women-categories')->with('success', 'Category Added Successfully!');
        }
        $levels = WomenCategory::where('parent_id', 0)->get();
        return view('admin.categories.add_women_category')->with('levels', $levels);
    }

    public function editManCategory(Request $request, $id = null) 
    {
    	
    	if($request->isMethod('post')) {
    		$category = Category::find($id);
    		$category->name = $request->input('category_name');
    		$category->description = $request->input('description');
    		$category->url = $request->input('url');
    		$category->parent_id = $request->input('parent_id');
    		$category->save();
    		return redirect(route('viewCategories'))->withSuccess('Category updated successfully!');
    	}
    	$category = Category::find($id);
     //    $ids_for_level = Category::whereIn('name', ['men', 'women'])->pluck('id');
    	$levels = Category::where('parent_id', 0)->get();
    	return view('admin.categories.edit_category', ['category' => $category])->with('levels', $levels);
    }

    public function editWomenCategory(Request $request, $id = null) 
    {
        
        if($request->isMethod('post')) {
            $category = WomenCategory::find($id);
            $category->name = $request->input('category_name');
            $category->description = $request->input('description');
            $category->url = $request->input('url');
            $category->parent_id = $request->input('parent_id');
            $category->save();
            return redirect(route('viewWomenCategories'))->withSuccess('Category updated successfully!');
        }
        $category = WomenCategory::find($id);
     //    $ids_for_level = Category::whereIn('name', ['men', 'women'])->pluck('id');
        $levels = WomenCategory::where('parent_id', 0)->get();
        return view('admin.categories.edit_women_category', ['category' => $category])->with('levels', $levels);
    }

    // view men categories
    public function viewCategories()
    {
    	$categories = Category::all();
    	return view('admin.categories.view_categories', ['categories' => $categories]);
    }

    //view women categories
    public function viewWomenCategories()
    {
        $categories = WomenCategory::all();
        return view('admin.categories.view_women_categories', ['categories' => $categories]);
    }

    public function deleteCategory($id) 
    {
    	Category:: find($id)->delete();

    	return redirect(route('viewCategories'))->withSuccess('Category deleted successfully!');
    }

    
}
