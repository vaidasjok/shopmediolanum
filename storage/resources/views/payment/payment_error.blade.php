
@extends('layouts.index')



@section('center')
<section id="cart_items">
    <div class="container">
       
            <div class="shopper-informations">
                <div class="row">
            
                    <div class="col-sm-12 clearfix" style="margin-bottom:20px">
                        <div class="bill-to">
                            <div class="form-one">
                                
								<h1 class="text-center">Something went to wrong.</h1>
								<div class="total_area">
									<p>{{$error}}</p>
									<a class="btn btn-default update" href="{{route('showPaymentPage')}}">Try pay again!</a>
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




