
@extends('layouts.index')



@section('center')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li class="active">Shopping Cart</li>
            </ol>
        </div>
       
       
       
       
       
            <div class="shopper-informations">
                <div class="row">
            
                    <div class="col-sm-12 clearfix">
                        <div class="bill-to">
                            <p> Shipping/Bill To</p>
                            <div class="form-one">
                                
                                          
                                <div class="total_area">
                                    <ul>
                                        <li>Client <span>{{$payment_info['last_name']}} {{$payment_info['first_name']}}</span></li>
                                        <li>Address <span>{{$payment_info['address']}}</span></li>
                                        <li>Zip <span>{{$payment_info['zip']}}</span></li>
                                        <li>Country <span>{{$country}}</span></li>
                                        <li>Payment Status 
                                          @if($payment_info['status'] == 'on_hold') 
                                          <span>not paid yet</span></li>
                                          @endif
                                        <li>Shipping Cost <span>Free</span></li>
                                        <li>Total <span>{{$payment_info['price']}}</span></li>
                                    </ul>
                                    <!-- <a class="btn btn-default update" href="">Refresh</a> -->
                                    <!-- <a class="btn btn-default check_out" >Pay Now</a> -->
                                    
                                    
                                </div>
                                          
                            </div>
                            <div class="form-two">
                                
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="col-sm-6 stripe-column">
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                     
                                        @if(session()->has('error'))
                                            <div class="alert alert-danger">
                                                {{ session()->get('error') }}
                                            </div>
                                        @endif
                                     
                                        @if(session()->has('success'))
                                            <div class="alert alert-success">
                                                {{ session()->get('success') }}
                                            </div>
                                        @endif
                                        <div class="row-buvo">

                                            <div class="col-lg-12-buvo">
                                                <form  action="/en/stripe-payment"  data-cc-on-file="false" data-stripe-publishable-key="pk_test_iS5sLGz5CONWxJ8KHhBzHHvD" name="frmStripe" id="frmstripe" method="post">
                                                    {{csrf_field()}}
                                                    <div class="row">
                                                        <div class="col-lg-12 form-group">
                                                            <label>Name on Card</label>
                                                            <input class="form-control" size="4" type="text" value="Testinis mokejimas">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12 form-group">
                                                            <label>Card Number</label>
                                                            <input autocomplete="off" class="form-control" size="20" type="text" name="card_no" value="4242424242424242">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-4 form-group">
                                                            <label>CVC</label>
                                                            <input autocomplete="off" class="form-control" placeholder="ex. 311" size="3" type="text" name="cvv" value="311">
                                                        </div>
                                                        <div class="col-lg-4 form-group">
                                                            <label>Expiration</label>
                                                            <input class="form-control" placeholder="MM" size="2" type="text" name="expiry_month" value="02">
                                                        </div>
                                                        <div class="col-lg-4 form-group">
                                                            <label> </label>
                                                            <input class="form-control" placeholder="YYYY" size="4" type="text" name="expiry_year" value="2021">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12 form-group">
                                                            <button class="form-control btn btn-success submit-button stripe-button" type="submit" style="margin-top: 10px;">Pay with » 
                                                                <img style="height: 45px;" src="{{asset('images/payment/stripe-logo-white.svg')}}"

                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
<!--                                         <a href="#" style="" class="stripe-button">Pay with »
                                            <img style="height: 45px;" src="{{asset('images/payment/stripe-logo-white.svg')}}" alt="">
                                        </a> -->
                                        {{--dd($payment_info)--}}
                                    </div>
                                    <div class="col-sm-6 paypal-column">
                                        <div style="margin: 65px 0px 20px;" id="paypal-button-container"></div>

                                        <script
                                            src="https://www.paypal.com/sdk/js?client-id=AZ1FhG1AHrPzcsqP9wlFuQGsCZab2LBkhRmzDvGQJPNJtU9CWep0PHzFtdKnpeEN1602XLo83_rSBaB8&currency=EUR"> // Required. Replace SB_CLIENT_ID with your sandbox client ID.

                                        </script>
                                        <script>

                                            paypal.Buttons({
                                                style: {
                                                    color: 'silver',
                                                    layout: 'horizontal'
                                                },
                                                createOrder: function(data, actions) {
                                                    // This function sets up the details of the transaction, including the amount and line item details.
                                                    return actions.order.create({
                                                        purchase_units: [{
                                                            amount: {
                                                                value: "{{$payment_info['price']}}"
                                                            }
                                                        }]
                                                    });
                                                },
                                                onApprove: function(data, actions) {
                                                  // This function captures the funds from the transaction.
                                                  return actions.order.capture().then(function(details) {
                                                    // This function shows a transaction success message to your buyer.
                                                    alert('Transaction completed by ' + details.payer.name.given_name);
                                                    // console.log(details);
                                                    window.location = './paymentreceipt/' + details.id + '/' + details.payer.payer_id;
                                                  });
                                                }
                                            }).render('#paypal-button-container');
                                        </script>
                                        
                                    </div> <!-- paypal-column --> 
                                </div>
                            </div> <!-- row --> 
                        </div>
                    </div>
                           
                </div>
            </div>
            
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
    </div>
</section> <!--/#payment-->




@endsection


