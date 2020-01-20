
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
                                        <li>Payment Status 
                                          @if($payment_info['status'] == 'on_hold') 
                                          <span>not paid yet</span></li>
                                          @endif
                                        <li>Shipping Cost <span>Free</span></li>
                                        <li>Total <span>{{$payment_info['price']}}</span></li>
                                    </ul>
                                    <a class="btn btn-default update" href="">Update</a>
                                    <!-- <a class="btn btn-default check_out" >Pay Now</a> -->

                                    <div style="margin: 40px 0px 20px;" id="paypal-button-container"></div>

                                    <script
                                        src="https://www.paypal.com/sdk/js?client-id=AZ1FhG1AHrPzcsqP9wlFuQGsCZab2LBkhRmzDvGQJPNJtU9CWep0PHzFtdKnpeEN1602XLo83_rSBaB8&currency=EUR"> // Required. Replace SB_CLIENT_ID with your sandbox client ID.
                                    </script>
                                    <script>

                                        paypal.Buttons({
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
                                </div>
                                          
                            </div>
                            <div class="form-two">
                                
                            </div>
                        </div>
                    </div>
                           
                </div>
            </div>
            
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
    </div>
</section> <!--/#payment-->




@endsection


