<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Product;
use App\Category;
use App\WomenCategory;
use App\Type;
use App\Cart;
use Session;
use Illuminate\Support\Fasades\Auth;

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
        return view('shophome', compact('products', 'categories'));
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

    public function setType($type)
    {
        Type::where('type', $type)->update(['is_active' => 1]);
        Type::where('type', '<>', $type)->update(['is_active' => 0]);

        return redirect()->route('allProducts');
    }

}
