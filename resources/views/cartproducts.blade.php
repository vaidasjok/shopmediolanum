@extends('layouts.index')

@section('center')

<section id="cart_items">
	<div class="container">
		@include('alert')
		<!-- <div class="breadcrumbs">
			<ol class="breadcrumb">
			  <li><a href="#">Home</a></li>
			  <li class="active">Shopping Cart</li>
			</ol>
		</div> -->
		<div class="table-responsive cart_info">
			<table class="table table-condensed">
				<thead>
					<tr class="cart_menu">
						<td class="image">Item</td>
						<td class="description"></td>
						<td class="size">Size</td>
						<td class="price">Price</td>
						<td class="quantity">Quantity</td>
						<td class="total">Total</td>
						<td></td>
					</tr>
				</thead>
				<tbody>
					@foreach($cartItems->items as $item)
					<tr>
						<td class="cart_product">
							<a href="/product/{{ $item['data']->id }}"><img src="{{Storage::disk('local')->url('product_images/' . $item['data']['image'])}}" height="70" alt=""></a>
						</td>
						<td class="cart_description">
							<h4><a href="/product/{{ $item['data']->id }}">{{$item['data']['name']}}</a></h4>
							<p>{{$item['data']['description']}} - {{$item['data']['type']}}</p>
							<p>id: {{$item['data']['id']}} - {{$item['attribute_id']}}</p>
						</td>
						<td class="size">
							<p>{{$item['size']}}</p>
						</td>
						<td class="cart_price">
							<p>{{$item['price']}}</p>
						</td>
						<td class="cart_quantity">
							<div class="cart_quantity_button">
								<a class="cart_quantity_up" href="{{route('increaseSingleProduct', ['attribute_id' => $item['attribute_id']])}}"> + </a>
								<input class="cart_quantity_input" type="text" name="quantity" value="{{$item['quantity']}}" autocomplete="off" size="2">
								<a class="cart_quantity_down" href="{{route('decreaseSingleProduct', ['attribute_id' => $item['attribute_id']])}}"> - </a>
							</div>
						</td>
						<td class="cart_total">
							<p class="cart_total_price">{{number_format($item['totalSinglePrice'], 2)}}</p>
						</td>
						<td class="cart_delete">
							<a class="cart_quantity_delete" href="{{route('deleteItemFromCart', [ 'attribute_id' => $item['attribute_id'] ])}}"><i class="fa fa-times"></i></a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</section> <!--/#cart_items-->

<section id="do_action">
	<div class="container">
		<div class="heading">
			<h3>What would you like to do next?</h3>
			<p>Choose if you have a discount coupon code.</p>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="chose_area">
					<ul class="user_option">
						<li>
							<form action="{{ url('/cart/apply-coupon') }}" method="post" name="apply_coupon">
								{{ csrf_field() }}
								<label for="coupon_code">Use Coupon Code</label>&nbsp;
								<input type="text" name="coupon_code" id="coupon_code">
								<input type="submit" value="Apply" class="btn btn-default">
							</form>
						</li>
					</ul>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="total_area">
					<ul>
						<li>Quantity <span>{{$cartItems->totalQuantity}}</span></li>
						<li>Shipping Cost <span>Free</span></li>
						@if(!empty(Session::get('couponAmount')))
							<li>Subtotal <span>{{number_format($cartItems->totalPrice, 2)}}</span></li>
							<li>Coupon Discount <span>-{{number_format(Session::get('couponAmount'), 2)}}</span></li>
							<li>Total <span>{{number_format($cartItems->totalPrice - Session::get('couponAmount'), 2)}}</span></li>
						@else
							<li>Total <span>{{$cartItems->totalPrice}}</span></li>
						@endif
					</ul>
<!-- 						<a class="btn btn-default update" href="">Update</a>
 -->						<a class="btn btn-default update" href="{{route('checkoutProducts')}}">Check Out</a>
				</div>
			</div>
		</div>
	</div>
</section><!--/#do_action-->
@endsection

