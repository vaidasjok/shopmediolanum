<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Category;
use App\WomenCategory;
use App\Type;
use App\ProductAttribute;
use App\ProductsImage;
use Image;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class AdminProductsController extends Controller
{
    public function index() 
    {
    	$products = Product::get();
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
        $size_and_fit = $request->input('size_and_fit');
        if(empty($request->input('enabled'))) {
            $enabled = 0;
        } else {
            $enabled = 1;
        }
        

        Validator::make($request->all(), ['image' => 'required|image|mimes:png,jpg,jpeg|max:2000'])->validate(); 
        $ext = $request->file('image')->getClientOriginalExtension(); //jpg
        $stringImageFormat = str_replace(' ', '', $request->input('name'));
        $imageName = $stringImageFormat . '-' . time() . "." . $ext;

        $imageEncoded = File::get($request->image);
        Storage::disk('local')->put('public/product_images/' . $imageName, $imageEncoded);

        $newProductArray = array('name' => $name, 'description' => $description, 'image' => $imageName, 'type' => $type, 'price' => $price, 'category_id' => $category_id, 'size_and_fit' => $size_and_fit, 'enabled' => $enabled ); 
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

    public function addProductImagesForm(Request $request, $id = null)
    {
        
        $product = Product::findOrFail($id);
        if($request->isMethod('post')) {
            $data = $request->all();
            // echo '<pre>'; print_r($data); die;
            if($request->hasFile('images')) {
                $files = $request->file('images');
                // echo '<pre>'; print_r($files); die;
                foreach($files as $file) {
                    // dd($file);
                    $image = new ProductsImage;
                    $imageEncoded = File::get($file);
                    // dd($imageEncoded);
                    $extension = $file->getClientOriginalExtension();
                    $filename = rand(111, 99999) . '.' . $extension;

                    $large_image_path = 'public/product_images/large/' . $filename;
                    $medium_image_path = 'public/product_images/medium/' . $filename;
                    $small_image_path = 'public/product_images/small/' . $filename;

                    Storage::disk('local')->put($large_image_path, $imageEncoded);
                    Storage::disk('local')->put($medium_image_path, $imageEncoded);
                    Storage::disk('local')->put($small_image_path, $imageEncoded);

                    //resize images
                    // $img_large = Image::make($large_image_path)->save($large_image_path);
                    $img_medium = Image::make($file)->resize(600, 600, function($constraint) {
                        $constraint->aspectRatio();
                    }); 
                    Storage::disk('local')->put($medium_image_path, $img_medium->encode());
                    // $img_medium->save(Storage::disk('local')->url('app/' . $medium_image_path));

                    $img_small = Image::make($file)->resize(300, 300, function($constraint) {
                        $constraint->aspectRatio();
                    });
                    Storage::disk('local')->put($small_image_path, $img_small->encode());
                    // $img_small->save(Storage::disk('local')->url('app/' . $small_image_path));

                    //save to db
                    $image->image = $filename;
                    $image->product_id = $data['product_id'];
                    $image->save();
                }
            }

            return redirect('admin/addProductImagesForm/' . $id)->withSuccess("Images have been added successfully.");
        }
        $product_images = ProductsImage::where('product_id', $id)->get();
        return view('admin.addProductImagesForm')->with(['product' => $product, 'product_images' => $product_images ]);
    }

    public function deleteProductImage($id) {
        $image = ProductsImage::findOrFail($id);
        $product_id = $image->product_id;

        //check if image exist in folder
        $exists_large = Storage::disk('local')->exists('public/product_images/large/' . $image->image);
        $exists_medium = Storage::disk('local')->exists('public/product_images/medium/' . $image->image);
        $exists_small = Storage::disk('local')->exists('public/product_images/small/' . $image->image);

        //delete image from folders
        if($exists_large) {
            Storage::delete('public/product_images/large/' . $image->image);
        }
        if($exists_medium) {
            Storage::delete('public/product_images/medium/' . $image->image);
        }
        if($exists_small) {
            Storage::delete('public/product_images/small/' . $image->image);
        }
        
        //delete image from database
        $image->delete();
        
        return redirect('admin/addProductImagesForm/' . $product_id)->withSuccess("Image has been deleted successfully.");
    }

    public function updateProduct(Request $request, $id)
    {
        $name = $request->input('name');
        $description = $request->input('description');
        $type = $request->input('type');
        $price = $request->input('price');
        $category_id = $request->input('category_id');
        $size_and_fit = $request->input('size_and_fit');
        if(empty($request->input('enabled'))) {
            $enabled = 0;
        } else {
            $enabled = 1;
        }

        $arrayToUpdate = array(
                            'name' => $name,
                            'description' => $description,
                            'type' => $type,
                            'price' => $price,
                            'category_id' => $category_id,
                            'size_and_fit' => $size_and_fit,
                            'enabled' => $enabled
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
