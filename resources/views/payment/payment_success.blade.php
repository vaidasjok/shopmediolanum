
@extends('layouts.index')



@section('center')
<section id="cart_items">
    <div class="container">
       
            <div class="shopper-informations">
                <div class="row">
            
                    <div class="col-sm-12 clearfix" style="margin-bottom:20px">
                        <div class="bill-to">
                            <div class="form-one">
                                
								<h1 class="text-center"> Thanks for choosing our product!</h1>
								<div class="total_area">
									<ul>
									<li>Order ID<span>{{$payment_info['order_id']}}</span></li>      

									</ul>
                                    <h2 style="padding-left: 20px;">Items:</h2>
                                    <ul>
                                        @foreach($order->orderItems as $item)
                                        <li>{{$item->item_name}}, size: {{$item->size}} <span>{{$item->quantity}}</span></li>
                                        @endforeach
                                    </ul>
                                    <div class="total" style="font-size: 120%;padding-left: 20px;">Total: {{$order->price}}€</div> <br>
									<a class="btn btn-default update" href="/">Shop Again!</a>
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




