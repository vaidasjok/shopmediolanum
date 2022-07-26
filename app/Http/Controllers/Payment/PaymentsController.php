<?php

namespace App\Http\Controllers\Payment;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Cart;
use App\Type;
use App\Country;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;




class PaymentsController extends Controller
{
    //


    public function index(){

     /*   $products = [0=> ["name"=>"Iphone","category"=>"smart phones","price"=>1000],
            1=> ["name"=>"Galaxy","category"=>"tablets","price"=>2000],
            2=> ["name"=>"Sony","category"=>"TV","price"=>3000]];*/

        $products = Product::paginate(3);

        return view("allproducts",compact("products"));

    }


  

    public function showPaymentPage(){

        $payment_info = Session::get('payment_info');
        $type = Type::where('is_active', 1)->first()->type;
        $country = $payment_info['country'];
        // dd($payment_info['country']);

            //has not paied
            if($payment_info['status'] == 'on_hold'){
                return view('payment.paymentpage',['payment_info' => $payment_info, 'type' => $type, 'country' => $country]);
             
            } else {
                if($type == 'men') {
                    return redirect()->route("showMenShoesPage");
                } else {
                    return redirect()->route("showWomenShoesPage");
                }
            }

    }



    private function storePaymentInfo($paypalPaymentID,$paypalPayerID){

        $payment_info = Session::get('payment_info');
        $order_id = $payment_info['order_id'];
        $status = $payment_info['status'];
        $paypal_payment_id = $paypalPaymentID;
        $paypal_payer_id = $paypalPayerID;


        if($status == 'on_hold'){
       
            //create (issue) a new payment row in payments table
            $date = date('Y-m-d H:i:s');
            $newPaymentArray = array("order_id"=>$order_id,"date"=>$date,"amount"=>$payment_info['price'],
                "paypal_payment_id"=>$paypal_payment_id, "paypal_payer_id" => $paypal_payer_id);

            $created_order = DB::table("payments")->insert($newPaymentArray);
           

            //update payment status in orders table to "paid"
       
            DB::table('orders')->where('order_id', $order_id)->update(['status' => 'paid']);
       
        }

    }



    public function showPaymentReceipt($paypalPaymentID,$paypalPayerID)
    {

        if(!empty($paypalPaymentID) && !empty($paypalPayerID)){
                  //will return json -> contains transaction status
                $this->validate_payment($paypalPaymentID,$paypalPayerID);

                $this->storePaymentInfo($paypalPaymentID,$paypalPayerID);

                 $payment_receipt = Session::get('payment_info');

                 $payment_receipt['paypal_payment_id'] = $paypalPaymentID;
                 $payment_receipt['paypal_payer_id'] = $paypalPayerID;

                //remove session

                  //delete payment_info from session
                    Session::forget("payment_info");
                    Session::flush();
           
                //return and pass relevant info

             return view('payment.paymentreceipt',['payment_receipt' => $payment_receipt]);

        } else {

                $type = Type::where('is_active', 1)->first()->type;
                if($type == 'men') {
                    return redirect()->route("showMenShoesPage");
                } else {
                    return redirect()->route("showWomenShoesPage");
                }

        }

    }








    private function validate_payment($paypalPaymentID, $paypalPayerID){

        $paypalEnv       = 'sandbox'; // Or 'production'
        $paypalURL       = 'https://api.sandbox.paypal.com/v1/'; //change this to paypal live url when you go live
        $paypalClientID  = 'AZ1FhG1AHrPzcsqP9wlFuQGsCZab2LBkhRmzDvGQJPNJtU9CWep0PHzFtdKnpeEN1602XLo83_rSBaB8';
        $paypalSecret   = 'EPJWdQLLrj1l4fTbtj65Hxn_AdPWP4aB94_zT3JuXJX856f5FC4vyCujw98vufkK6LSExO_hUK-Xo638';
    


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $paypalURL.'oauth2/token');
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $paypalClientID.":".$paypalSecret);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        $response = curl_exec($ch);
        curl_close($ch);
        
        if(empty($response)){
            return false;
        }else{
            $jsonData = json_decode($response);
            $curl = curl_init($paypalURL.'payments/payment/'.$paypalPaymentID);
            curl_setopt($curl, CURLOPT_POST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer ' . $jsonData->access_token,
                'Accept: application/json',
                'Content-Type: application/xml'
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            
            // Transaction data
            $result = json_decode($response);
            
            return $result;
        }
    
    }














    

    public function showCart(){

        $cart = Session::get('cart');

        //cart is not empty
        if($cart){
            return view('cartproducts',['cartItems'=> $cart]);
         //cart is empty
        }else{
            $type = Type::where('is_active', 1)->first()->type;
            if($type == 'men') {
                return redirect()->route("showMenShoesPage");
            } else {
                return redirect()->route("showWomenShoesPage");
            }
        }

    }





    public function checkoutProducts(){
    
   //   return redirect()->route('checkoutProducts');
    return view('checkoutproducts');
    
    }




    public function createNewOrder(Request $request)
    {
        $cart = Session::get('cart');

        $first_name = $request->input('first_name');
        $address = $request->input('address');
        // $country = $request->input('country');
        $country = Country::where('country_id', '=', $request->input('country'))->first()->value;
        // dd($country);
        $last_name = $request->input('last_name');
        $zip = $request->input('zip');
        $phone = $request->input('phone');
        $email = $request->input('email');

        //cart is not empty
        if($cart) {
            // dd($cart);
            $date = date('Y-m-d H:i:s');
            $newOrderArray = array("status" => "on_hold", "date" => $date, "del_date" => $date, "price" => $cart->totalPrice, 'first_name' => $first_name, 'address' => $address, 'country' => $country, 'last_name' => $last_name, 'zip' => $zip, 'phone' => $phone, 'email' => $email);
            $createdOrder = DB::table('orders')->insert($newOrderArray);
            $order_id = DB::getPdo()->LastInsertId();

            foreach($cart->items as $cart_item) {
                $item_id = $cart_item['data']['id'];
                $item_name = $cart_item['data']['name'];
                $item_price = $cart_item['data']['price'];
                $item_quantity = $cart_item['quantity'];
                $item_size = $cart_item['size'];
                // reikia prideti kieki 
                $newItemsInCurrentOrder = array('item_id' => $item_id, 'order_id' => $order_id, 'item_name' => $item_name, 'item_price' => $item_price, 'quantity' => $item_quantity, 'size' => $item_size);
                $createdOrderItems = DB::table('order_items')->insert($newItemsInCurrentOrder);
            }

            //delete cart
            Session::forget('cart');
            // Session::flush();

            $payment_info = $newOrderArray; //manau, kad dar reikia prideti prio masyvo order_id reiksme
            $payment_info['order_id'] = $order_id;
            $request->session()->put('payment_info', $payment_info);
            // print_r($newOrderArray);
            return redirect()->route('showPaymentPage');
        } else {
            $type = Type::where('is_active', 1)->first()->type;
            if($type == 'men') {
                return redirect()->route("showMenShoesPage");
            } else {
                return redirect()->route("showWomenShoesPage");
            }
        }
    }







   public function getPaymentInfoByOrderId($order_id){
   
        $paymentInfo = DB::table('payments')->where('order_id', $order_id)->get();
         return json_encode($paymentInfo[0]);


   }




   


}



