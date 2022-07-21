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
							{{--@if($category->women_categories != null)--}}
							{{--@if(count($category->women_categories) > 0)--}}

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
											@if($category->women_categories != null)
											@if(count($category->women_categories) > 0)
											@foreach($category->women_categories as $subcat)
											<li><a href="/{{ App::getLocale() }}/{{ $type }}/{{$subcat->url}}">{{$subcat->name}} </a></li>
											@endforeach
											@endif
											@endif

											@if($category->categories != null)
											@if(count($category->categories) > 0)
											@foreach($category->categories as $subcat)
											<li><a href="/{{ App::getLocale() }}/{{ $type }}/{{$subcat->url}}@if(request()->has('brand_id'))?brand_id={{ request()->get('brand_id') }}@endif">{{$subcat->name}} </a></li>
											@endforeach
											@endif
											@endif
<!-- 											----
											<li><a href="">Nike </a></li>
											<li><a href="">Under Armour </a></li>
											<li><a href="">Adidas </a></li>
											<li><a href="">Puma</a></li>
											<li><a href="">ASICS </a></li>
 -->										</ul>
									</div>
								</div>
							</div>
							{{--@endif--}}
							{{--@endif--}}
							@endforeach
						</div><!--/category-productsr-->
					
						<div class="brands_products"><!--brands_products-->
							<h2>Brands</h2>
							<div class="brands-name">
								<ul class="nav nav-pills nav-stacked">
									@foreach($brands as $brand)
										@if($brand->number_of_products != 0)
										<li><a href="?brand_id={{$brand->id}}"> <span class="pull-right">({{$brand->number_of_products}})</span>{{$brand->name}}</a></li>
										@endif
									@endforeach
								</ul>
							</div>
						</div><!--/brands_products-->
						

						
						<div class="shipping text-center"><!--shipping-->
							<img src="/images/home/shipping.jpg" alt="" />
						</div><!--/shipping-->
						<br>
						
					</div>
				</div>
				
				<div class="col-sm-9 padding-right">
					<div class="features_items"><!--features_items-->
						<!-- <h2 class="title text-center">Features Items</h2> -->
						@if($products->count() == 0 ) So far the category has no products @endif
						@foreach($products->chunk(3) as $chunks)
						<div class="row">
						@foreach($chunks as $product)
							<div class="col-sm-4">
							<div class="product-image-wrapper">
								<div class="single-products">
										<div class="productinfo text-center">
											{{ csrf_field() }}
											<img src="{{Storage::disk('local')->url('product_images/large/' . $product->image)}}" alt="" />
											<h2>{{number_format($product->price, 0)}} €</h2>
											<p>{{$product->name}}</p>
											@if($product->brand->name)
											<p style="font-size:90%;">{{$product->brand->name}}</p>
											@endif
											<a href="#" class="btn btn-default add-to-cart"><!-- <i class="fa fa-shopping-cart"></i> --><!-- Add to cart -->View</a>
										</div>
										<div class="product-overlay">
											<div class="overlay-content">
												<h2>{{number_format($product->price, 0)}} €</h2>
												<p>{{$product->name}}</p>
												<!-- <a href="{{route('addToCartProduct', ['id' => $product->id])}}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a> -->
												<a href="/{{ App::getLocale() }}/product/{{ $product->id }}" class="ajaxGET-disable btn btn-default add-to-cart">
													<div class="url" style="display: none;">{{route('addToCartAjaxGet', ['id' => $product->id])}}</div>
													<!-- <i class="fa fa-shopping-cart"></i> -->View</a>
											</div>
										</div>
								</div>
								<div class="choose">
									<ul class="nav nav-pills nav-justified">
										<li class="@if((Session::has('wishlist') && array_key_exists($product->id, Session::get('wishlist')->getList()))) wishlist @endif"><a href="/{{ App::getLocale() }}/products/add-to-wishlist/{{$product->id}}"><i class="ikona icon-star-1">&#xe804;</i><span>Add to wishlist</span></a></li>
										<!-- <li><a href="#"><i class="fa fa-plus-square"></i>Add to compare</a></li> -->
									</ul>
								</div>
							</div>
						</div>

						@endforeach
						</div>
						@endforeach

					</div><!--features_items-->
					{{ $products->appends(request()->input())->links() }}
					<!-- <ul class="pagination">
						<li class="active"><a href="">1</a></li>
						<li><a href="">2</a></li>
						<li><a href="">3</a></li>
						<li><a href="">&raquo;</a></li>
					</ul> -->
				</div>
			</div>
		</div>
	</section>


	
@endsection
