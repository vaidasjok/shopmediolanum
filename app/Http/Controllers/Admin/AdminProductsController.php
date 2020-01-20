<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Category;
use App\WomenCategory;
use App\Type;
use App\ProductAttribute;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class AdminProductsController extends Controller
{
    public function index() 
    {
    	$products = Product::paginate(3);
    	return view('admin.displayProducts', ['products' => $products]);
    }

    //send new product data to database
    public function sendCreateProductForm(Request $request)
    {
        $name = $request->input('name');
        $description = $request->input('description');
        $type = $request->input('type');
        $price = $request->input('price');
        $category_id = $request->input('category_id');

        Validator::make($request->all(), ['image' => 'required|image|mimes:png,jpg,jpeg|max:2000'])->validate(); 
        $ext = $request->file('image')->getClientOriginalExtension(); //jpg
        $stringImageFormat = str_replace(' ', '', $request->input('name'));
        $imageName = $stringImageFormat . '-' . time() . "." . $ext;

        $imageEncoded = File::get($request->image);
        Storage::disk('local')->put('public/product_images/' . $imageName, $imageEncoded);

        $newProductArray = array('name' => $name, 'description' => $description, 'image' => $imageName, 'type' => $type, 'price' => $price, 'category_id' => $category_id); 
        $created = DB::table('products')->insert($newProductArray);

        if($created) {
            return redirect()->route('adminDisplayProducts');
        } else {
            return "Product was not created";
        }
    }

    public function getCategoriesForNewProduct(Request $request) 
    {
        $active_type = $request->input('type');
        if($active_type == 'men') {
            $categories = Category::where('parent_id', 0)->get();
        } else {
            $categories = WomenCategory::where('parent_id', 0)->get();
        }
        
        $categories_dropdown = "<option selected disabled>Select</option>";
        $selected = "";
        foreach($categories as $cat) {
            $categories_dropdown .= "<option value = '" . $cat->id . "' >" . $cat->name . "</option>";
            $sub_categories = Category::where('parent_id', $cat->id)->get();
            foreach($sub_categories as $sub_cat) {
                $categories_dropdown .= "<option value = '" . $sub_cat->id . "' >&nbsp;--&nbsp;" . $sub_cat->name . "</option>";
                $selected = '';
            }
        }
        return response()->json(['categories_dropdown' => $categories_dropdown]);

    }

    //display edit product form
    public function editProductForm($id) 
    {
    	$product = Product::find($id);
        $type = $product->type;
        if($type == 'men') {
            $categories = Category::where('parent_id', 0)->get();
        } else {
            $categories = WomenCategory::where('parent_id', 0)->get();
        }
        $categories_dropdown = "<option selected disabled>Select</option>";
        $selected = "";
        foreach($categories as $cat) {
            if($product->category_id == $cat->id) {
                $selected = "selected";
            }
            $categories_dropdown .= "<option value = '" . $cat->id . "'" . $selected . " >" . $cat->name . "</option>";
            $selected = '';

            if($type == 'men') {
                $sub_categories = Category::where('parent_id', $cat->id)->get();
            } else {
                $sub_categories = WomenCategory::where('parent_id', $cat->id)->get();
            }
            // $sub_categories = Category::where('parent_id', $cat->id)->get();
            foreach($sub_categories as $sub_cat) {
                if($product->category_id == $sub_cat->id) {
                    $selected = "selected";
                }
                $categories_dropdown .= "<option value = '" . $sub_cat->id . "'" . $selected . " >&nbsp;--&nbsp;" . $sub_cat->name . "</option>";
                $selected = '';
            }
        }

    	return view('admin.editProductForm', ['product' => $product, 'categories_dropdown' => $categories_dropdown]);
    }

    //display edit product image form
    public function editProductImageForm($id) 
    {
    	$product = Product::find($id);
    	return view('admin.editProductImageForm', ['product' => $product]);
    }

    public function updateProductImage(Request $request, $id) 
    {
        Validator::make($request->all(), ['image' => 'required|image|mimes:png,jpg,jpeg|max:2000'])->validate(); 

        if($request->hasFile('image')) {
            $product = Product::find($id);
            $exists = Storage::disk('local')->exists('public/product_images/' . $product->image);

            //delete old image
            if($exists) {
                Storage::delete('public/product_images/' . $product->image);
            }

            //upload new image
            //$ext = $request->file('image')->getClientOriginalExtension(); //jpg
            $request->image->storeAs('public/product_images/', $product->image);
            $arrayToUpdate = array('image' => $product->image);
            DB::table('products')->where('id', $id)->update($arrayToUpdate);

            return redirect()->route('adminDisplayProducts');
            
        } else {
            $error = "No image was selected";
            return $error;
        }
    }

    public function updateProduct(Request $request, $id)
    {
        $name = $request->input('name');
        $description = $request->input('description');
        $type = $request->input('type');
        $price = $request->input('price');
        $category_id = $request->input('category_id');

        $arrayToUpdate = array(
                            'name' => $name,
                            'description' => $description,
                            'type' => $type,
                            'price' => $price,
                            'category_id' => $category_id
                        );

        DB::table('products')->where('id', $id)->update($arrayToUpdate);

        return redirect()->route('adminDisplayProducts');
    }

    public function createProductForm()
    {
        // $categories = Category::all();
        $active_type = Type::where('is_active', 1)->first();
        if($active_type->type == 'men') {
            $categories = Category::where('parent_id', 0)->get();
        } else {
            $categories = WomenCategory::where('parent_id', 0)->get();
        }
        // $categories = Category::where('parent_id', 0)->get();
        $categories_dropdown = "<option selected disabled>Select</option>";
        foreach($categories as $cat) {
            $categories_dropdown .= "<option value = '" . $cat->id . "'>" . $cat->name . "</option>";
            $sub_categories = Category::where('parent_id', $cat->id)->get();
            foreach($sub_categories as $sub_cat) {
                $categories_dropdown .= "<option value = '" . $sub_cat->id . "'>&nbsp;--&nbsp;" . $sub_cat->name . "</option>";
            }
        }

        return view('admin.createProductForm', ['categories' => $categories ])->with(compact('categories_dropdown'));
    }


    public function deleteProduct($id)
    {
        $product = Product::find($id);

        $exists = Storage::disk('local')->exists('public/product_images/' . $product->image);

        //delete old image
        if($exists) {
            Storage::delete('public/product_images/' . $product->image);
        }

        Product::destroy($id);

        return redirect()->route('adminDisplayProducts');
    }


    public function addAttributes(Request $request, $id = null)
    {
        

        if(!$id == null) {
            $product = Product::with('attributes')->find($id);
        } 
        
        if($request->isMethod('post')) {
            Validator::make($request->all(), ['sku' => 'required','size' => 'required', 'price' => 'required', 'stock' => 'required'])->validate(); 
            $data = $request->all();
            // dd($data);
            foreach($data['sku'] as $key => $val) {
                if(!empty($val)) {

                    // do not allow to enter the same sku value
                    $attrCountSKU = ProductAttribute::where('sku', $val)->count();
                    if($attrCountSKU > 0) {
                        return redirect('admin/add-attributes/' . $data['product_id'])->withDanger('SKU already exists! Please add another SKU.');
                    }

                    //do not allow to add the same size
                    $attrCountSize = ProductAttribute::where(['product_id' => $id, 'size' => $data['size'][$key] ])->count();
                    if($attrCountSize > 0) {
                        return redirect('admin/add-attributes/' . $data['product_id'])->withDanger("Size '" . $data['size'][$key] . "' already exists! Please add another size.");
                    }

                    $attribute = new ProductAttribute;
                    $attribute->sku = $val;
                    $attribute->product_id = $data['product_id'];
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->save();


                }
            }

            return redirect('admin/add-attributes/' . $data['product_id'])->withSuccess('Product Attributes Successfully Added!');
        }
        return view('admin.add_attributes')->with(compact('product'));
    }

    public function deleteAttribute($id = null) 
    {
        ProductAttribute::find($id)->delete();
        return redirect()->back()->withSuccess('Attribute deleted successfully!');
    }

    public function editAttributes(Request $request, $id)
    {
        if($request->isMethod('post')) {
            $data = $request->all();
            // echo '<pre>'; echo print_r($data); die;
            foreach($data['idAttr'] as $key => $attr ) {
                ProductAttribute::where('id', $data['idAttr'][$key])->update(['price' => $data['price'][$key], 'stock' => $data['stock'][$key]]);
            }
        }
        return redirect()->back()->withSuccess('Attributes updated successfully!');
    }

    public function ordersPanel()
    {
        $orders = DB::table('orders')->paginate(10);
        return view('admin.ordersPanel', ['orders' => $orders]);
    }

    public function deleteOrder(Request $request, $id)
    {
        $deleted = DB::table('orders')->where('order_id', $id)->delete();

        if($deleted) {
            return redirect()->back()->with('orderDeletionStatus', 'Order ' . $id . ' was successfully deleted');
        } else {
            return redirect()->back()->with('orderDeletionStatus', 'Order ' . $id . ' was NOT deleted');
        }
    }

    public function editOrderForm($order_id)
    {
        $order = DB::table('orders')->where('order_id', $order_id)->get();
        return view('admin.editOrderForm', ['order' => $order[0]]);
    }

    public function updateOrder(Request $request, $order_id)
    {
        $date = $request->input('date');
        $del_date = $request->input('del_date');
        $price = $request->input('price');
        $status = $request->input('status');

        $update_array = array('date' => $date, 'del_date' => $del_date, 'price' => $price, 'status' => $status);

        $result = DB::table('orders')->where('order_id', $order_id)->update($update_array);
        return redirect()->route('ordersPanel');
       
    }
    

}
