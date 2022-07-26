<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Home | shopMediolanum</title>
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/prettyPhoto.css')}}" rel="stylesheet">
    <link href="{{asset('css/price-range.css')}}" rel="stylesheet">
    <link href="{{asset('css/animate.css')}}" rel="stylesheet">
	<link href="{{asset('css/main.css')}}" rel="stylesheet">
	<link href="{{asset('css/app.css')}}" rel="stylesheet">
	<link href="{{asset('css/responsive.css')}}" rel="stylesheet">
	<link href="{{asset('css/easyzoom.css')}}" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       

    <script src="{{asset('js/jquery.js')}}"></script>
</head><!--/head-->

<body>
	<header id="header"><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container header-container">
				<div class="row">
					<div class="col-md-3">
						<div class="language-type">
							<a href="/{{ App::getLocale() }}/lang/en" class="english">EN</a>
							<a href="/{{ App::getLocale() }}/lang/ru" class="russian">RU</a>
{{-- App::getLocale() --}}
							<div class="type">
								<a class="{{ (request()->is(App::getLocale() . '/women/*')) ? 'active' : '' }}" href="/{{ App::getLocale() }}/set-type/women">{{ __('Women') }}</a>
								<a class="{{ (request()->is(App::getLocale() . '/men/*')) ? 'active' : '' }}" href="/{{ App::getLocale() }}/set-type/men">{{ __('Men') }}</a>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="text-center logo">
							<a href="/"><img src="{{asset('images/home/logo 4.svg')}}" alt="" /></a>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="social-icons pull-right">
							<ul class="nav navbar-nav">
								<!-- <li><a href="#"><i class="fa fa-facebook"></i></a></li> -->
								<li><a href="/view-wishlist"><i class="ikona icon-star-1">&#xe804;</i>
									<span id="wishlistQuantity" class="cart-with-numbers">
									@if(Session::has('wishlist') && Session::get('wishlist')->totalQuantity > 0 )
	                                	{{ Session::get('wishlist')->totalQuantity }}
		                            @endif
		                            </span>
								</a></li>
								<li class="cart"><a href="{{route('cartProducts')}}"><i class="ikona icon-bag">&#xe801;</i>
									<span id="totalQuantity" class="cart-with-numbers">
									@if(Session::has('cart') && Session::get('cart')->totalQuantity > 0 )
	                                	{{ Session::get('cart')->totalQuantity }}
		                            @endif
		                            </span>
								</a></li>
								@if(Auth::check())
								<li><a href="{{route('home')}}"><i class="ikona icon-user">&#xe805;</i></a></li>
								@else
								<li><a href="/login"><i class="ikona icon-user">&#xe805;</i></a></li>
								@endif
							</ul>
						</div>
					</div>
				</div>
				<div class="search-block">
					<form action="#" class="ff-search ">
						<input class="search-search" type="text" placeholder="{{ __('Search') }}" value="">
					</form>
				</div>
				
			</div>
		</div><!--/header_top-->
		
		<div class="header-middle header-container"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-md-8 clearfix" >
					<ul class="shop-menu">
						<li><a class="sale-link" href="#">{{ __('Sale') }}</a></li>
						<li><a href="/{{ App::getLocale() }}/{{ $type }}/clothing">{{ __('Clothing') }}</a></li>
						<li><a href="/{{ App::getLocale() }}/{{ $type }}/shoes">{{ __('Shoes') }}</a></li>
						<li><a href="/{{ App::getLocale() }}/{{ $type }}/accessoiries">{{ __('Accessoiries') }}</a></li>
						<li><a href="/{{ App::getLocale() }}/{{ $type }}/perfumes">{{ __('Perfumes') }}</a></li>
					</ul>

					</div>
					<div class="col-md-4 clearfix">
						<div class="shop-menu clearfix pull-right">

						</div>
					</div>
				</div>

			</div>
			
		</div><!--/header-middle-->
		<div class="advert-band">
			{{ __('Sale. Shop Up to 50%') }} 
		</div>
		View name: {{$view_name}}
		