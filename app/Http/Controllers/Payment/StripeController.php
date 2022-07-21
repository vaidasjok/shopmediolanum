<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe;
use Session;
use App\Type;
use Exception;
use App\Order;
use Illuminate\Support\Facades\DB;

class StripeController extends Controller
{
    public function stripe()
    {
        return view('stripe');
    }
    public function payStripe(Request $request)
    {
        $this->validate($request, [
            'card_no' => 'required',
            'expiry_month' => 'required',
            'expiry_year' => 'required',
            'cvv' => 'required',
        ]);

        $stripe = Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        try {
            $response = \Stripe\Token::create(array(
                "card" => array(
                    "number"    => $request->input('card_no'),
                    "exp_month" => $request->input('expiry_month'),
                    "exp_year"  => $request->input('expiry_year'),
                    "cvc"       => $request->input('cvv')
                )));
            if (!isset($response['id'])) {
                return redirect()->route('addmoney.paymentstripe');
            }
            $charge = \Stripe\Charge::create([
                'card' => $response['id'],
                'currency' => 'USD',
                'amount' =>  100 * 100,
                'description' => 'wallet',
            ]);

            if($charge['status'] == 'succeeded') {
                // reikia issiusti laiska su atlikto mokejimo informacija

                //reikia pakeisti uzsakymo statusa i 'apmoketa'


                $payment_info = Session::get('payment_info');
                // dd($payment_info);
                $type = Type::where('is_active', 1)->first()->type;
                // $order = DB::table('orders')->where('order_id', $payment_info['order_id'])->update(['status' => 'paid']);

                $order = Order::where('order_id', $payment_info['order_id'])->with('orderItems')->first();
                $order->status = 'paid';
                $order->save();
                // dd($order);
                return view('payment.payment_success', compact('payment_info', 'type', 'order'));

            } else {
                // return redirect('showPaymentPage')->with('error', 'Something went to wrong.');
                return 'neveikia';
            }

        }
        catch (Exception $e) {
            $type = Type::where('is_active', 1)->first()->type;
            $error =  $e->getMessage();
            return view('payment.payment_error', compact('error', 'type'));
        }

    }


}
