<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// senesnis shop home
// Route::get('/', ['uses' => 'ProductsController@index', 'as' => 'allProducts']);

//shop home page
Route::get('/', ['uses' => 'ProductsController@shophome', 'as' => 'shophome']);

Route::get('products', ['uses' => 'ProductsController@index', 'as' => 'allProducts']);

//men products
Route::get('products/men', ['uses' => 'ProductsController@menProducts', 'as' => 'menProducts']);

//women products
Route::get('products/women', ['uses' => 'ProductsController@womenProducts', 'as' => 'womenProducts']);

//category page
Route::get('products/{url}', ['uses' => 'ProductsController@products', 'as' => 'products']);

//search
Route::get('search', ['uses' => 'ProductsController@search', 'as' => 'searchProducts']);

Route::get('produtcs/addtocart/{id}', ['uses' => 'ProductsController@addProductToCart', 'as' => 'addToCartProduct']);

//show car items
Route::get('cart', ['uses' => 'ProductsController@showCart', 'as' => 'cartProducts']);

//delete item from cart
Route::get('produtcs/deleteItemFromCart/{id}', ['uses' => 'ProductsController@deleteItemFromCart', 'as' => 'deleteItemFromCart']);

//increase single product
Route::get('product/increaseSingleProduct/{id}', ['uses' => 'ProductsController@increaseSingleProduct', 'as' => 'increaseSingleProduct']);


//decrease single product
Route::get('product/decreaseSingleProduct/{id}', ['uses' => 'ProductsController@decreaseSingleProduct', 'as' => 'decreaseSingleProduct']);

//checkout products
Route::get('product/checkoutProducts', ['uses' => 'ProductsController@checkoutProducts', 'as' => 'checkoutProducts']);

//process checkout page 
Route::post('product/createNewOrder', ['uses' => 'Payment\PaymentsController@createNewOrder', 'as' => 'createNewOrder']);

//create an order (naudojamas tik testuotuojant)
Route::get('product/createOrder', ['uses' => 'ProductsController@createOrder', 'as' => 'createOrder']);

//payment page
Route::get('payment/paymentpage', ['uses' => 'Payment\PaymentsController@showPaymentPage', 'as' => 'showPaymentPage']);

//process payment and receipt page
Route::get('payment/paymentreceipt/{paymentID}/{payerID}', ['uses' => 'Payment\PaymentsController@showPaymentReceipt', 'as' => 'showPaymentReceipt']);



//user authentication
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


//ADMIN PANEL

Route::group(['middleware' => ['restrictToAdmin']], function() {

//overview - all products
Route::get('admin/products', ['uses' => 'Admin\AdminProductsController@index', 'as' => 'adminDisplayProducts'])->middleware('restrictToAdmin');

//display edit product form
Route::get('admin/editProductForm/{id}', ['uses' => 'Admin\AdminProductsController@editProductForm', 'as' => 'adminEditProductForm']);

//display edit product image form
Route::get('admin/editProductImageForm/{id}', ['uses' => 'Admin\AdminProductsController@editProductImageForm', 'as' => 'adminEditProductImageForm']);

//update product image
Route::post('admin/updateProductImage/{id}', ['uses' => 'Admin\AdminProductsController@updateProductImage', 'as' => 'adminUpdateProductImage']);

//update product data
Route::post('admin/updateProduct/{id}', ['uses' => 'Admin\AdminProductsController@updateProduct', 'as' => 'adminUpdateProduct']);

//display create product page
Route::get('admin/createProductForm', ['uses' => 'Admin\AdminProductsController@createProductForm', 'as' => 'adminCreateProductForm']);

//send new product data to database
Route::post('admin/sendCreateProductForm', ['uses' => 'Admin\AdminProductsController@sendCreateProductForm', 'as' => 'adminSendCreateProductForm']);

//delete product
Route::get('admin/deleteProduct/{id}', ['uses' => 'Admin\AdminProductsController@deleteProduct', 'as' => 'adminDeleteProduct']);

//orders control panel
Route::get('/admin/ordersPanel', ['uses' => 'Admin\AdminProductsController@ordersPanel', 'as' => 'ordersPanel']);

//delete order
Route::get('admin/deleteOrder/{id}', ['uses' => 'Admin\AdminProductsController@deleteOrder', 'as' => 'adminDeleteOrder']);

Route::get('payment/getPaymentInfoByOrderId/{order_id}', ['uses' => 'Payment\PaymentsController@getPaymentInfoByOrderId', 'as' => 'getPaymentInfoByOrderId']);

//display edit order form
Route::get('admin/editOrderForm/{id}', ['uses' => 'Admin\AdminProductsController@editOrderForm', 'as' => 'adminEditOrderForm']);

//update order data
Route::post('admin/updateOrder/{order_id}', ['uses' => 'Admin\AdminProductsController@updateOrder', 'as' => 'adminUpdateOrder']);

//category routes (admin)
Route::match(['get', 'post'], 'admin/add-category', ['uses' => 'CategoryController@addCategory', 'as' => 'addCategory']);

Route::match(['get', 'post'], 'admin/add-women-category', ['uses' => 'CategoryController@addWomenCategory', 'as' => 'addWomenCategory']);


Route::get('admin/view-categories', ['uses' => 'CategoryController@viewCategories', 'as' => 'viewCategories']);

Route::get('admin/view-women-categories', ['uses' => 'CategoryController@viewWomenCategories', 'as' => 'viewWomenCategories']);

Route::match(['get', 'post'], 'admin/edit-category/{id}', ['uses' => 'CategoryController@editManCategory', 'as' => 'editManCategory']);

Route::match(['get', 'post'], 'admin/edit-women-category/{id}', ['uses' => 'CategoryController@editWomenCategory', 'as' => 'editWomenCategory']);

Route::match(['get', 'post'], 'admin/delete-category/{id}', ['uses' => 'CategoryController@deleteCategory', 'as' => 'deleteCategory']);

Route::match(['get', 'post'], 'admin/delete-women-category/{id}', ['uses' => 'CategoryController@deleteWomenCategory', 'as' => 'deleteWomenCategory']);


//product attributes
Route::match(['get', 'post'], 'admin/add-attributes/{id?}', ['uses' => 'Admin\AdminProductsController@addAttributes', 'as' => 'addAttributes']);

Route::get('admin/delete-attribute/{id}', ['uses' => 'Admin\AdminProductsController@deleteAttribute', 'as' => 'deleteAttribute']);


Route::match(['get', 'post'], '/admin/edit-attributes/{id}', ['uses' => 'Admin\AdminProductsController@editAttributes', 'as' => 'editAttributes']);


Route::get('admin/nustatymai', function() {


	// $type = new \App\Type;
	// $type->type = 'men';
	// $type->is_active = 1;
	// $type->save();

	// $type = new \App\Type;
	// $type->type = 'women';
	// $type->is_active = 0;
	// $type->save();

});

//get categories with ajax when creating new product
Route::get('admin/get-categories-for-new-product', ['uses' => 'Admin\AdminProductsController@getCategoriesForNewProduct', 'as' => 'getCategoriesForNewProduct']);



}); //end Route::group





Route::get('set-type/{type}', ['uses' => 'ProductsController@setType', 'as' => 'setType']);

//adding to cart using Ajax post request
Route::post('products/addToCartAjaxPost', ['uses' => 'ProductsController@addToCartAjaxPost', 'as' => 'addToCartAjaxPost']);


//adding to cart using Ajax get request
Route::get('products/addToCartAjaxGet/{id}', ['uses' => 'ProductsController@addToCartAjaxGet', 'as' => 'addToCartAjaxGet']);

