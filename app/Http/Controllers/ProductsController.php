<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Product;
use App\ProductAttribute;
use App\Category;
use App\WomenCategory;
use App\CategoryTranslation;
use App\WomenCategoryTranslation;
use App\Type;
use App\Cart;
use App\ProductsImage;
use App\Coupon;
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
            $products = Product::where('type' ,'men')->where('enabled', 1)->paginate(3);
        } else {
            $products = Product::where('type', 'women')->where('enabled', 1)->paginate(3);
        }
        // dd($categories);
        $type = $active_type->type;
        return view('shophome', compact('products', 'categories', 'type'));
    }

    public function showMenShoesPage(Request $request)
    {
        // dd($request->getRequestUri());
        $active_type = Type::where('is_active', 1)->first();
        $shoe_category_id = CategoryTranslation::where('name', 'shoes')->first()->category_id;

        //get list of shoe category and child categories ids for products
        $shoe_categories_ids = Category::where('parent_id', $shoe_category_id)->pluck('id')->toArray();

        $categories = Category::with('categories')->where('id', $shoe_category_id)->get();
        // print_r($shoe_categories_ids); die;

        if($active_type->type == 'men') {
            $products = Product::where('type' ,'men')->whereIn('category_id', $shoe_categories_ids)->where('enabled', 1)->paginate(12);
        } else {
            $products = Product::where('type', 'women')->whereIn('category_id', $shoe_categories_ids)->where('enabled', 1)->paginate(12);
        }
        $type = $active_type->type;
        // dd($type);
        return view('all_shoes', compact('products', 'categories', 'type'));

    }

    public function showMenClothingPage()
    {

        $active_type = Type::where('is_active', 1)->first();
        $clothing_category_id = CategoryTranslation::where('name', 'Clothing')->first()->category_id;

        //get list of shoe category and child categories ids for products
        $clothing_categories_ids = Category::where('parent_id', $clothing_category_id)->pluck('id')->toArray();

        $categories = Category::with('categories')->where('id', $clothing_category_id)->get();
        // print_r($shoe_categories_ids); die;

        if($active_type->type == 'men') {
            $products = Product::where('type' ,'men')->whereIn('category_id', $clothing_categories_ids)->where('enabled', 1)->paginate(12);
        } else {
            $products = Product::where('type', 'women')->whereIn('category_id', $clothing_categories_ids)->where('enabled', 1)->paginate(12);
        }
        $type = $active_type->type;
        return view('all_shoes', compact('products', 'categories', 'type'));
        // return view('all_clothes');
    }

    public function showMenAccessoiriesPage()
    {
        $active_type = Type::where('is_active', 1)->first();
        $accessoiries_category_id = CategoryTranslation::where('name', 'Accessoiries')->first()->category_id;

        //get list of shoe category and child categories ids for products
        $accessoiries_categories_ids = Category::where('parent_id', $accessoiries_category_id)->pluck('id')->toArray();

        $categories = Category::with('categories')->where('id', $accessoiries_category_id)->get();
        // print_r($shoe_categories_ids); die;

        if($active_type->type == 'men') {
            $products = Product::where('type' ,'men')->whereIn('category_id', $accessoiries_categories_ids)->where('enabled', 1)->paginate(12);
        } else {
            $products = Product::where('type', 'women')->whereIn('category_id', $accessoiries_categories_ids)->where('enabled', 1)->paginate(12);
        }
        $type = $active_type->type;
        return view('all_shoes', compact('products', 'categories', 'type'));
    }

    public function showMenParfumesPage()
    {
        $active_type = Type::where('is_active', 1)->first();
        $parfumes_category_id = CategoryTranslation::where('name', 'Perfumes')->first()->category_id;

        //get list of shoe category and child categories ids for products
        $parfumes_categories_ids = Category::where('parent_id', $parfumes_category_id)->pluck('id')->toArray();

        $categories = Category::with('categories')->where('id', $parfumes_category_id)->get();
        // print_r($shoe_categories_ids); die;

        if($active_type->type == 'men') {
            $products = Product::where('type' ,'men')->whereIn('category_id', $parfumes_categories_ids)->where('enabled', 1)->paginate(12);
        } else {
            $products = Product::where('type', 'women')->whereIn('category_id', $parfumes_categories_ids)->where('enabled', 1)->paginate(12);
        }
        $type = $active_type->type;
        return view('all_shoes', compact('products', 'categories', 'type'));
    }

    public function showWomenClothingPage()
    {
        $active_type = Type::where('is_active', 1)->first();
        $clothes_category_id = WomenCategoryTranslation::where('name', 'clothing')->first()->women_category_id;

        //get list of shoe category and child categories ids for products
        $clothes_categories_ids = Category::where('parent_id', $clothes_category_id)->pluck('id')->toArray();

        $categories = WomenCategory::with('women_categories')->where('id', $clothes_category_id)->get();
        // print_r($shoe_categories_ids); die;

        if($active_type->type == 'men') {
            $products = Product::where('type' ,'men')->whereIn('category_id', $clothes_categories_ids)->where('enabled', 1)->paginate(12);
        } else {
            $products = Product::where('type', 'women')->whereIn('category_id', $clothes_categories_ids)->where('enabled', 1)->paginate(12);
        }
        $type = $active_type->type;
        return view('all_shoes', compact('products', 'categories', 'type'));
    }

    public function showWomenAccessoiriesPage()
    {
        $active_type = Type::where('is_active', 1)->first();
        $accessoiries_category_id = WomenCategoryTranslation::where('name', 'accessoiries')->first()->women_category_id;

        //get list of shoe category and child categories ids for products
        $accessoiries_categories_ids = Category::where('parent_id', $accessoiries_category_id)->pluck('id')->toArray();

        $categories = WomenCategory::with('women_categories')->where('id', $accessoiries_category_id)->get();
        // print_r($shoe_categories_ids); die;

        if($active_type->type == 'men') {
            $products = Product::where('type' ,'men')->whereIn('category_id', $accessoiries_categories_ids)->where('enabled', 1)->paginate(12);
        } else {
            $products = Product::where('type', 'women')->whereIn('category_id', $accessoiries_categories_ids)->where('enabled', 1)->paginate(12);
        }
        $type = $active_type->type;
        return view('all_shoes', compact('products', 'categories', 'type'));
    }

    public function showWomenParfumesPage()
    {
        $active_type = Type::where('is_active', 1)->first();
        $parfumes_category_id = WomenCategoryTranslation::where('name', 'perfumes')->first()->women_category_id;

        //get list of shoe category and child categories ids for products
        $parfumes_categories_ids = Category::where('parent_id', $parfumes_category_id)->pluck('id')->toArray();

        $categories = WomenCategory::with('women_categories')->where('id', $parfumes_category_id)->get();
        // print_r($shoe_categories_ids); die;

        if($active_type->type == 'men') {
            $products = Product::where('type' ,'men')->whereIn('category_id', $parfumes_categories_ids)->where('enabled', 1)->paginate(12);
        } else {
            $products = Product::where('type', 'women')->whereIn('category_id', $parfumes_categories_ids)->where('enabled', 1)->paginate(12);
        }
        $type = $active_type->type;
        return view('all_shoes', compact('products', 'categories', 'type'));
    }

    public function showWomenShoesPage()
    {
        $active_type = Type::where('is_active', 1)->first();
        $shoe_category_id = WomenCategoryTranslation::where('name', 'shoes')->first()->women_category_id;

        //get list of shoe category and child categories ids for products
        $shoe_categories_ids = WomenCategory::where('parent_id', $shoe_category_id)->pluck('id')->toArray();

        $categories = WomenCategory::with('women_categories')->where('id', $shoe_category_id)->get();
        // dd($categories);
        // print_r($categories); die;

        if($active_type->type == 'men') {
            $products = Product::where('type' ,'men')->whereIn('category_id', $shoe_categories_ids)->where('enabled', 1)->paginate(3);
        } else {
            $products = Product::where('type', 'women')->whereIn('category_id', $shoe_categories_ids)->where('enabled', 1)->paginate(3);
        }
        $type = $active_type->type;
        return view('all_shoes', compact('products', 'categories', 'type'));

    }

    public function showTypeCategoryProducts(Request $request, $type, $category_url)
    {
        $url = $category_url;
        // dd($url);
        
        $active_type = Type::where('is_active', 1)->first();

        if($type == 'women') {
            $category_id = WomenCategory::where('url', $url)->first()->id;

            $parent_category_id = WomenCategory::where('url', $url)->first()->parent_id;
            $categories = WomenCategory::with('women_categories')->where('id', $parent_category_id)->get();
        } else {
            $category_id = Category::where('url', $url)->first()->id;

            $parent_category_id = Category::where('url', $url)->first()->parent_id;
            $categories = Category::with('categories')->where('id', $parent_category_id)->get();

        }
        

        // print_r($shoe_categories_ids); die;

        if($active_type->type == 'men') {
            $products = Product::where('type' ,'men')->where('category_id', $category_id)->where('enabled', 1)->paginate(9);
        } else {
            $products = Product::where('type', 'women')->where('category_id', $category_id)->where('enabled', 1)->paginate(9);
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
            $products = Product::where('type' ,'men')->where('enabled', 1)->paginate(3);
        } else {
            $products = Product::where('type', 'women')->where('enabled', 1)->paginate(3);
        }
        
    	return view('allproducts', compact('products', 'categories'));
    }

    

    public function menProducts()
    {
        $products = DB::table('products')->where('type', '=', 'men')->where('enabled', 1)->get();

        return view('menProducts', compact('products'));
    }

    public function womenProducts()
    {
        $products = DB::table('products')->where('type', '=', 'women')->where('enabled', 1)->get();
        
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
        $type = Type::where('is_active', 1)->first()->type;

        //cart is not empty
        if($cart) {
            return view('cartproducts', ['cartItems' => $cart, 'type' => $type]);
        //cart is empty
        } else {
            return redirect()->route('showMenShoesPage');
        }

    }

    public function deleteItemFromCart(Request $request, $id) {
        
        Session::forget('couponAmount');
        Session::forget('couponCode');

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
        $active_type = Type::where('is_active', 1)->first()->type;
        return view('checkoutproducts', ['type' => $active_type]);
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

    public function increaseSingleProduct(Request $request, $attribute_id) 
    {
        Session::forget('couponAmount');
        Session::forget('couponCode');

        $prevCart = $request->session()->get('cart');
        $cart = new Cart($prevCart);

        $attribute = ProductAttribute::where('id', $attribute_id)->first();
        $prodId = $attribute->product_id;
        $product = Product::find($prodId);
        //reikia gauti price ir size
        $price = $attribute->price;
        $size = $attribute->size;
        $cart->addItem($attribute_id, $product, $price, $size);
        $request->session()->put('cart', $cart);
        // dump($cart);

        return redirect()->route('cartProducts');
    }

    public function decreaseSingleProduct(Request $request, $attribute_id) 
    {
        Session::forget('couponAmount');
        Session::forget('couponCode');

        $prevCart = $request->session()->get('cart');
        $cart = new Cart($prevCart);

        $cart->removeItem($attribute_id);
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

    //example purposes only
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

    //actually used
    public function addToCartAjaxPostTwo(Request $request)
    {
        Session::forget('couponAmount');
        Session::forget('couponCode');

        $selSize = $request->input('selSize');

        $attr = explode('-', $selSize);
        // dd($attr);
        $attribute_id = $attr[2];
        $product_id = $attr[0];

        $prevCart = $request->session()->get('cart');
        $cart = new Cart($prevCart);

        $product = Product::find($product_id);
        $attribute = ProductAttribute::where('id', $attribute_id)->first();
        
        $price = $attribute->price;
        $size = $attribute->size;
        $cart->addItem($attribute_id, $product, $price, $size);
        $request->session()->put('cart', $cart);
        // dump($cart);
        return response()->json([ 'totalQuantity' => $cart->totalQuantity ]); 
    }

    //disabled
    public function addToCartAjaxGet(Request $request, $attribute_id, $product_id)
    {
        $prevCart = $request->session()->get('cart');
        $cart = new Cart($prevCart);

        $product = Product::find($product_id);
        $attribute = ProductAttribute::where($attribute_id)->first();
        $price = $attribute->price;
        $size = $attribute->size;
        $cart->addItem($attribute_id, $product, $price, $size);
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
            ->id)->where('enabled', 1)->get();
        $categories = Category::with('categories')->where('parent_id', 0)->get();
        // echo '<pre>'; print_r($categories); die;
        //dd($products);
        return view('listings')->with(compact('products', 'categories', 'categoryDetails'));
    }

    public function product($id = null)
    {
        $productsCount = Product::where('id', $id)->where('enabled', 1)->count();
        if($productsCount == 0) {
            abort(404);
        }

        $product = Product::with('attributes')->where('id', $id)->first();

        // $product = json_decode(json_encode($product));
        // print '<pre>'; print_r($product); die;

        $relatedProducts = Product::where('category_id', $product->category_id)->where('id', "<>", $product->id)->where('enabled', 1)->get();
        // dd($relatedProducts);

        $active_type = Type::where('is_active', 1)->first();
        if($active_type->type == 'men') {
            $categoryDetails = Category::where('id', $product->category_id)->first();
        } else {
            $categoryDetails = WomenCategory::where('id', $product->category_id)->first();
        }
        $categories = Category::with('categories')->where('parent_id', 0)->get();

        //get product alternate images
        $productAltImages = ProductsImage::where('product_id', $id)->get();

        $total_stock = ProductAttribute::where('product_id', $id)->sum('stock');   
        
        return view('products.detail', ['type' => $active_type->type])->with(compact('product', 'categories', 'categoryDetails', 'productAltImages', 'total_stock', 'relatedProducts'));
    }

    public function getProductPrice(Request $request)
    {
        $idSize = $request->input('idSize');
        // echo '<pre>'; print_r($idSize); die;
        $proArr = explode('-', $idSize);
        $proAttr = ProductAttribute::where(['product_id' => $proArr[0], 'size' => $proArr[1]])->first();
        echo $proAttr->price;
        echo '#';
        echo $proAttr->stock;
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

    public function applyCoupon(Request $request)
    {
        Session::forget('couponAmount');
        Session::forget('couponCode');

        $data = $request->all();
        // echo '<pre>'; print_r($data); die;
        $couponCount = Coupon::where('coupon_code', $data['coupon_code'])->count();
        if($couponCount == 0) {
            return redirect()->back()->withError('Coupon is not walid.');
        } else {
            $coupon = Coupon::where('coupon_code', $data['coupon_code'])->first();

            if($coupon->status == 0) {
                return redirect()->back()->withError('This coupon is not active!');
            }

            $expiry_date = $coupon->expiry_date;
            $current_date = date('Y-m-d');
            // echo $current_date; die;
            if($expiry_date < $current_date) {
                return redirect()->back()->withError('This coupon has expired.');
            }

            // get total amoount of the cart
            $total_amount = Session::get('cart')->totalPrice;
            // echo $total_amount; die;
            if($coupon->amount_type == "Fixed") {
                $couponAmount = $coupon->amount;
            } else {
                $couponAmount = $total_amount * ($coupon->amount / 100);
            }

            //add coupon code & amount in session
            Session::put('couponAmount', $couponAmount);
            Session::put('couponCode', $data['coupon_code']);

            return redirect()->back()->withSuccess('Coupon code successfully applied.');
        }

    }

}
