<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Product;
use App\ProductAttribute;
use App\Category;
use App\WomenCategory;
use App\Type;
use App\Cart;
use App\ProductsImage;
use Session;
use Illuminate\Support\Fasades\Auth;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    
    public function shophome()
    {

        $active_type = Type::where('is_active', 1)->first();
        if($active_type->type == 'men') {
            $categories = Category::with('categories')->where('parent_id', 0)->get();
        } else {
            $categories = WomenCategory::with('categories')->where('parent_id', 0)->get();
        }
        

        if($active_type->type == 'men') {
            $products = Product::where('type' ,'men')->paginate(3);
        } else {
            $products = Product::where('type', 'women')->paginate(3);
        }
        // dd($categories);
        $type = $active_type->type;
        return view('shophome', compact('products', 'categories', 'type'));
    }

    public function showMenShoesPage()
    {
        $active_type = Type::where('is_active', 1)->first();
        $shoe_category_id = Category::where('name', 'shoes')->first()->id;

        //get list of shoe category and child categories ids for products
        $shoe_categories_ids = Category::where('parent_id', $shoe_category_id)->pluck('id')->toArray();

        $categories = Category::with('categories')->where('id', $shoe_category_id)->get();
        // print_r($shoe_categories_ids); die;

        if($active_type->type == 'men') {
            $products = Product::where('type' ,'men')->whereIn('category_id', $shoe_categories_ids)->paginate(3);
        } else {
            $products = Product::where('type', 'women')->whereIn('category_id', $shoe_categories_ids)->paginate(3);
        }
        $type = $active_type->type;
        return view('all_shoes', compact('products', 'categories', 'type'));

    }

    public function showWomenShoesPage()
    {
        $active_type = Type::where('is_active', 1)->first();
        $shoe_category_id = WomenCategory::where('name', 'shoes')->first()->id;

        //get list of shoe category and child categories ids for products
        $shoe_categories_ids = WomenCategory::where('parent_id', $shoe_category_id)->pluck('id')->toArray();

        $categories = WomenCategory::with('categories')->where('id', $shoe_category_id)->get();
        // print_r($shoe_categories_ids); die;

        if($active_type->type == 'men') {
            $products = Product::where('type' ,'men')->whereIn('category_id', $shoe_categories_ids)->paginate(3);
        } else {
            $products = Product::where('type', 'women')->whereIn('category_id', $shoe_categories_ids)->paginate(3);
        }
        $type = $active_type->type;
        return view('all_shoes', compact('products', 'categories', 'type'));

    }

    public function showTypeCategoryProducts(Request $request, $type, $category_url)
    {
        $url = $category_url;
        
        $active_type = Type::where('is_active', 1)->first();

        if($type == 'women') {
            $category_id = WomenCategory::where('url', $url)->first()->id;

            $parent_category_id = WomenCategory::where('url', $url)->first()->parent_id;
            $categories = WomenCategory::with('categories')->where('id', $parent_category_id)->get();
        } else {
            $category_id = Category::where('url', $url)->first()->id;

            $parent_category_id = Category::where('url', $url)->first()->parent_id;
            $categories = Category::with('categories')->where('id', $parent_category_id)->get();

        }
        

        // print_r($shoe_categories_ids); die;

        if($active_type->type == 'men') {
            $products = Product::where('type' ,'men')->where('category_id', $category_id)->paginate(3);
        } else {
            $products = Product::where('type', 'women')->where('category_id', $category_id)->paginate(3);
        }
        $type = $active_type->type;
        return view('type_category_products', compact('products', 'categories', 'type'));
    }

    //
    public function index() {
    	// $products = [
    	// 	0 => ['name' => 'Iphone',
    	// 		'category' => 'smart phones',
    	// 		'price' => 1000
    	// 	],
    	// 	1 => ['name' => 'Galaxy',
    	// 		'category' => 'tablets',
    	// 		'price' => 2000
    	// 	],
    	// 	2 => ['name' => 'Sony',
    	// 		'category' => 'TV',
    	// 		'price' => 3000
    	// 	]
    	// ];
     //    foreach($products as $product) {
     //        $newproduct = new Product;
     //        $newproduct->name = $product['name'];
     //        $newproduct->description = 'laikinas aprasymas';
     //        $newproduct->image = 'laikinas image';
     //        $newproduct->type = 'laikinas type';
     //        $newproduct->price = $product['price'];
     //        $newproduct->save();
     //    }
        $active_type = Type::where('is_active', 1)->first();
        if($active_type->type == 'men') {
            $categories = Category::where('parent_id', 0)->get();
        } else {
            $categories = WomenCategory::where('parent_id', 0)->get();
        }
        
        // foreach($categories as $cat) {
        //     echo $cat->name; echo "<br>";
        //     $sub_categories = Category::where('parent_id', $cat->id)->get();
        //     foreach($sub_categories as $subcat) {
        //         echo $subcat->name; echo "<br>";
        //     }
        // }

        if($active_type->type == 'men') {
            $products = Product::where('type' ,'men')->paginate(3);
        } else {
            $products = Product::where('type', 'women')->paginate(3);
        }
        
    	return view('allproducts', compact('products', 'categories'));
    }

    

    public function menProducts()
    {
        $products = DB::table('products')->where('type', '=', 'men')->get();

        return view('menProducts', compact('products'));
    }

    public function womenProducts()
    {
        $products = DB::table('products')->where('type', '=', 'women')->get();
        
        return view('womenProducts', compact('products'));
    }

    public function search(Request $request)
    {
        $searchText = $request->get('searchText');
        $products = Product::where('name', 'Like', '%' . $searchText . '%')->paginate(3);
        return view('allproducts', compact('products'));
    }

    public function addProductToCart(Request $request, $id) {
        // $request->session()->flush();

        $prevCart = $request->session()->get('cart');
        $cart = new Cart($prevCart);

        $product = Product::find($id);
        $cart->addItem($id, $product);
        $request->session()->put('cart', $cart);
        // dump($cart);
        return redirect()->route('allProducts');
    }

    public function showCart() 
    {
        $cart = Session::get('cart');

        //cart is not empty
        if($cart) {
            return view('cartproducts', ['cartItems' => $cart]);
        //cart is empty
        } else {
            return redirect()->route('allProducts');
        }
    }

    public function deleteItemFromCart(Request $request, $id) {
        $cart = $request->session()->get('cart');
        if(array_key_exists($id, $cart->items)) {
            unset($cart->items[$id]);
        }

        $prevCart = $request->session()->get('cart');
        $updatedCart = new Cart($prevCart);
        $updatedCart->updatePriceAndQuantity();
        $request->session()->put('cart', $updatedCart);

        return redirect()->route('cartProducts');
    }


    public function checkoutProducts()
    {
        return view('checkoutproducts');
    }

    //sis metodas nenaudojamas, naudojamas toks pat Payment\PaymentsController
    public function createNewOrder(Request $request)
    {
        $cart = Session::get('cart');

        $first_name = $request->input('first_name');
        $address = $request->input('address');
        $last_name = $request->input('last_name');
        $zip = $request->input('zip');
        $phone = $request->input('phone');
        $email = $request->input('email');

        

        //cart is not empty
        if($cart) {
            // dd($cart);
            $date = date('Y-m-d H:i:s');
            $newOrderArray = array("status" => "on_hold", "date" => $date, "del_date" => $date, "price" => $cart->totalPrice, 'first_name' => $first_name, 'address' => $address, 'last_name' => $last_name, 'zip' => $zip, 'phone' => $phone, 'email' => $email);
            $createdOrder = DB::table('orders')->insert($newOrderArray);
            $order_id = DB::getPdo()->LastInsertId();

            foreach($cart->items as $cart_item) {
                $item_id = $cart_item['data']['id'];
                $item_name = $cart_item['data']['name'];
                $item_price = $cart_item['data']['price'];
                $newItemsInCurrentOrder = array('item_id' => $item_id, 'order_id' => $order_id, 'item_name' => $item_name, 'item_price' => $item_price);
                $createdOrderItems = DB::table('order_items')->insert($newItemsInCurrentOrder);
            }

            //delete cart
            Session::forget('cart');
            // Session::flush();

            $payment_info = $newOrderArray; //manau, kad dar reikia prideti prio masyvo order_id reiksme
            $request->session()->put('payment_info', $payment_info);
            // print_r($newOrderArray);
            return redirect()->route('showPaymentPage');
        } else {
            return redirect()->route('allProducts');
        }
    }

    public function increaseSingleProduct(Request $request, $id) 
    {
        $prevCart = $request->session()->get('cart');
        $cart = new Cart($prevCart);

        $product = Product::find($id);
        $cart->addItem($id, $product);
        $request->session()->put('cart', $cart);
        // dump($cart);

        return redirect()->route('cartProducts');
    }

    public function decreaseSingleProduct(Request $request, $id) 
    {
        $prevCart = $request->session()->get('cart');
        $cart = new Cart($prevCart);

        $cart->removeItem($id);
        $request->session()->put('cart', $cart);
        // dump($cart);
        
        return redirect()->route('cartProducts');
    }

    public function createOrder()
    {
        $cart = Session::get('cart');

        //cart is not empty
        if($cart) {
            // dd($cart->items);
            // dd(count($cart->items));
            $date = date('Y-m-d H:i:s');
            $newOrderArray = array("status" => "on_hold", "date" => $date, "del_date" => $date, "price" => $cart->totalPrice);
            $createdOrder = DB::table('orders')->insert($newOrderArray);
            $order_id = DB::getPdo()->LastInsertId();

            foreach($cart->items as $cart_item) {
                $item_id = $cart_item['data']['id'];
                $item_name = $cart_item['data']['name'];
                $item_price = $cart_item['data']['price'];
                $newItemsInCurrentOrder = array('item_id' => $item_id, 'order_id' => $order_id, 'item_name' => $item_name, 'item_price' => $item_price);
                $createdOrderItems = DB::table('order_items')->insert($newItemsInCurrentOrder);
            }

            //delete cart
            Session::forget('cart');
            Session::flush();
            return redirect()->route('allProducts')->withsuccess("Thanks For Choosing Us");
        } else {
            return redirect()->route('allProducts');
        }
    }

    public function addToCartAjaxPost(Request $request)
    {
        $id = $request->input('id');

        $prevCart = $request->session()->get('cart');
        $cart = new Cart($prevCart);

        $product = Product::find($id);
        $cart->addItem($id, $product);
        $request->session()->put('cart', $cart);
        // dump($cart);
        return response()->json([ 'totalQuantity' => $cart->totalQuantity ]);
    }

    public function addToCartAjaxGet(Request $request, $id)
    {
        $prevCart = $request->session()->get('cart');
        $cart = new Cart($prevCart);

        $product = Product::find($id);
        $cart->addItem($id, $product);
        $request->session()->put('cart', $cart);
        // dump($cart);
        return response()->json([ 'totalQuantity' => $cart->totalQuantity ]); 
    }

    public function products($url = null)
    {
        $active_type = Type::where('is_active', 1)->first();
        if($active_type->type == 'men') {
            $categoryDetails = Category::where('url', $url)->first();
        } else {
            $categoryDetails = WomenCategory::where('url', $url)->first();
        }
        $products = Product::where('category_id', $categoryDetails
            ->id)->get();
        $categories = Category::with('categories')->where('parent_id', 0)->get();
        // echo '<pre>'; print_r($categories); die;
        //dd($products);
        return view('listings')->with(compact('products', 'categories', 'categoryDetails'));
    }

    public function product($id = null)
    {
        $product = Product::with('attributes')->where('id', $id)->first();

        // $product = json_decode(json_encode($product));
        // print '<pre>'; print_r($product); die;

        $active_type = Type::where('is_active', 1)->first();
        if($active_type->type == 'men') {
            $categoryDetails = Category::where('id', $product->category_id)->first();
        } else {
            $categoryDetails = WomenCategory::where('id', $product->category_id)->first();
        }
        $categories = Category::with('categories')->where('parent_id', 0)->get();

        //get product alternate images
        $productAltImages = ProductsImage::where('product_id', $id)->get();
        
        return view('products.detail', ['type' => $active_type->type])->with(compact('product', 'categories', 'categoryDetails', 'productAltImages'));
    }

    public function getProductPrice(Request $request)
    {
        $idSize = $request->input('idSize');
        // echo '<pre>'; print_r($idSize); die;
        $proArr = explode('-', $idSize);
        $proAttr = ProductAttribute::where(['product_id' => $proArr[0], 'size' => $proArr[1]])->first();
        echo $proAttr->price; die;
    }

    public function setType($type)
    {
        Type::where('type', $type)->update(['is_active' => 1]);
        Type::where('type', '<>', $type)->update(['is_active' => 0]);

        if($type == 'men') {
            return redirect()->route('showMenShoesPage');
        } else {
            return redirect()->route('showWomenShoesPage');
        }
        
    }



}
