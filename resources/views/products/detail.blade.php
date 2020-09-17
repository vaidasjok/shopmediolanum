@extends('layouts.index')

@section('center')


	</header>

	<div class="container">
			@include('alert')
	</div>
	
	<section id="advertisement">
		<div class="container">
			<img src="images/shop/advertisement.jpg" alt="" />
		</div>
	</section>
	
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<div class="left-sidebar">
						<h2>Category</h2>
						<div class="panel-group category-products" id="accordian"><!--category-productsr-->
							@foreach($categories as $category)
							@if(count($category->categories) > 0)
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordian" href="#{{$category->name}}">
											<span class="badge pull-right"><i class="fa fa-plus"></i></span>
											{{$category->name}}
										</a>
									</h4>
								</div>
								<div id="{{$category->name}}" class="panel-collapse collapse">
									<div class="panel-body">
										<ul>
											@foreach($category->categories as $subcat)
											<li><a href="/{{ App::getLocale() }}/{{ $type }}/{{$subcat->url}}">{{$subcat->name}} </a></li>
											@endforeach
										</ul>
									</div>
								</div>
							</div>
							@endif
							@endforeach
						</div><!--/category-productsr-->
					
						<div class="brands_products"><!--brands_products-->
							<h2>Brands</h2>
							<div class="brands-name">
								<ul class="nav nav-pills nav-stacked">
									<li><a href=""> <span class="pull-right">(50)</span>Acne</a></li>
									<li><a href=""> <span class="pull-right">(56)</span>Grüne Erde</a></li>
									<li><a href=""> <span class="pull-right">(27)</span>Albiro</a></li>
									<li><a href=""> <span class="pull-right">(32)</span>Ronhill</a></li>
									<li><a href=""> <span class="pull-right">(5)</span>Oddmolly</a></li>
									<li><a href=""> <span class="pull-right">(9)</span>Boudestijn</a></li>
									<li><a href=""> <span class="pull-right">(4)</span>Rösch creative culture</a></li>
								</ul>
							</div>
						</div><!--/brands_products-->
						
						
						<div class="shipping text-center"><!--shipping-->
							<img src="images/home/shipping.jpg" alt="" />
						</div><!--/shipping-->
						
					</div>
				</div>
				
				<div class="col-sm-9 padding-right">
					<div class="product-details"><!--product-details-->
						<div class="col-sm-6">
							<div class="view-product">
								<div class="easyzoom easyzoom--overlay easyzoom--with-thumbnails">
									<a href="{{asset ('storage')}}/product_images/{{$product['image']}}">
										<img style="width: 500px; max-width: 100%" class="mainImage" src="{{asset ('storage')}}/product_images/{{$product['image']}}" alt="" />
									</a>
								</div>


								<h3>ZOOM</h3>
							</div>
							<div id="similar-product" class="carousel slide" data-ride="carousel">
								
								  <!-- Wrapper for slides --> 
								    <div class="carousel-inner">
										<div class="item active thumbnails">
											@foreach($productAltImages as $altimage)
												<a href="{{ asset('storage/product_images/large/' . $altimage->image) }}" data-standard="{{ asset('storage/product_images/small/' . $altimage->image) }}">
										  			<img class="changeImage" style="width: 80px; cursor: pointer;" src="{{ asset('storage/product_images/small/' . $altimage->image) }}" alt="">
										  		</a>
										  	@endforeach
										</div>
										
									</div>

								  <!-- Controls -->
								 <!--  <a class="left item-control" href="#similar-product" data-slide="prev">
									<i class="fa fa-angle-left"></i>
								  </a>
								  <a class="right item-control" href="#similar-product" data-slide="next">
									<i class="fa fa-angle-right"></i>
								  </a> -->
							</div>

						</div>
						<div class="col-sm-6">
							<div id="getLang">{{ App::getLocale() }}</div>
							<div class="product-information"><!--/product-information-->
								<img src="/images/product-details/new.jpg" class="newarrival" alt="" />
								<h2>{{ $product->name }}</h2>
								<p>Product Code: {{ $product->id }}</p>
								<p>
									<select name="size" id="selSize" style="width: 150px;">
										<option value="">{{ __('Select Size') }}</option>
										@foreach($product->attributes as $attr)
										<option value="{{$product->id}}-{{$attr->size}}-{{$attr->id}}">{{$attr->size}}</option>
										@endforeach
									</select>
								</p>
								<img src="images/product-details/rating.png" alt="" />
								<span>
									<span id="getPrice">€ {{ $product->price }}</span>
									{{csrf_field()}}
									@if($total_stock > 0)
									<button type="button" id="cartButton" class="ajaxPOST btn btn-default product-cart cart">
										<i class="fa fa-shopping-cart"></i>
										Add to cart
									</button>
									@endif
								</span>
								<p><b>Availability: </b><span id="availability"> @if($total_stock > 0) In Stock @else Out Of Stock @endif</span></p>
								<p><b>Brand:</b> E-SHOPPER</p>
								<a href=""><img src="images/product-details/share.png" class="share img-responsive"  alt="" /></a>
							</div><!--/product-information-->
						</div>
					</div><!--/product-details-->
					
					<div class="category-tab shop-details-tab"><!--category-tab-->
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#details" data-toggle="tab">The Details</a></li>
								<li><a href="#sizeandfit" data-toggle="tab">Size & Fit</a></li>
								<li><a href="#shipping" data-toggle="tab">Shipping & Free Returns</a></li>
							</ul>
						</div>
						<div class="tab-content">
							<div class="tab-pane fade active in" id="details" >
								<div class="description-wrapper">
									{!! nl2br(e($product->description)) !!}
								</div>
							</div>
							
							<div class="tab-pane fade" id="sizeandfit" >
								<div class="size-and-fit-wrapper">
									{{ $product->size_and_fit }}
								</div>
							</div>
							
							<div class="tab-pane fade" id="shipping" >
								<div class="shipping-information-wrapper">
									Shipping information - fixed information
								</div>
							</div>
														
						</div>
					</div><!--/category-tab-->
					
					<div class="recommended_items"><!--recommended_items-->
						<h2 class="title text-center">recommended items</h2>
						
						<div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
							<div class="carousel-inner">
								@php
									$count = 1;
								@endphp
								@foreach($relatedProducts->chunk(3) as $chunk)
								<div class="item @if($count == 1) active @endif">
									@foreach($chunk as $item)
									<div class="col-xs-4">
										<div class="product-image-wrapper">
											<div class="single-products">
												<div class="productinfo text-center">
													<img style="" src="{{asset ('storage')}}/product_images/{{$item->image}}" alt="" />
													<h2>€ {{ $item->price }}</h2>
													<p>{{ $item->name }}</p>
													<a href="/{{ App::getLocale() }}/product/{{ $item->id}}" class="btn btn-default add-to-cart">View</a>
												</div>
											</div>
										</div>
									</div>
									@php 
										$count++;
									@endphp
									@endforeach
								</div>
								@endforeach
								</div>
							<!-- </div> -->
							 <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
								<i class="fa fa-angle-left"></i>
							  </a>
							  <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
								<i class="fa fa-angle-right"></i>
							  </a>			
						</div>
					</div><!--/recommended_items-->
					
				</div>
			</div>
		</div>
	</section>

	<script>
		$(document).ready(function() {
			$('.ajaxGET').click(function(e) {
				e.preventDefault();
				var url = $(this).find('.url').text();
				var _token = $("input[name = '_token']").val();

				$.ajax({
					method: "GET",
					url: url,
					data: {_token: _token},
					success: function(data, status, XHR) {
						// alert(data.totalQuantity);
						if(data.totalQuantity > 0) {
							$('#totalQuantity').text(data.totalQuantity);
						}
					},
					error: function(xhr, status, error) {
						alert(error);
					}
				});
			});
		});
	</script>

	
@endsection
