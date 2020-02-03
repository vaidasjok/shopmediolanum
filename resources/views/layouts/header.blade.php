<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Home | E-Shopper</title>
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/prettyPhoto.css')}}" rel="stylesheet">
    <link href="{{asset('css/price-range.css')}}" rel="stylesheet">
    <link href="{{asset('css/animate.css')}}" rel="stylesheet">
	<link href="{{asset('css/main.css')}}" rel="stylesheet">
	<link href="{{asset('css/app.css')}}" rel="stylesheet">
	<link href="{{asset('css/responsive.css')}}" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="{{asset('images/ico/favicon.ico')}}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{asset('images/ico/apple-touch-icon-144-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{asset('images/ico/apple-touch-icon-114-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{asset('images/ico/apple-touch-icon-72-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" href="{{asset('images/ico/apple-touch-icon-57-precomposed.png')}}">
    <script src="{{asset('js/jquery.js')}}"></script>
</head><!--/head-->

<body>
	<header id="header"><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-sm-3">
						<div class="language-type">
							<a href="#" class="english">EN</a>
							<a href="#" class="russian">RU</a>
							<a class="type" href="/set-type/women">Women</a>
							<a href="/set-type/men">Men</a>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="text-center logo">
							<a href="/"><img src="{{asset('images/home/logo 4.svg')}}" alt="" /></a>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="social-icons pull-right">
							<ul class="nav navbar-nav">
								<!-- <li><a href="#"><i class="fa fa-facebook"></i></a></li> -->
								<li><a href="#"><i class="ikona icon-star-1">&#xe804;</i></a></li>
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
								<li><a href="/login"><i class="ikona icon-user">&#xe805;</i>
								@endif
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header_top-->
		
		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-md-4 clearfix">
						<div class="logo pull-left">
							<a href="/"><img src="{{asset('images/home/logo.png')}}" alt="" /></a>
						</div>
						<div class="btn-group pull-right clearfix">
							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
									USA
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<li><a href="">Canada</a></li>
									<li><a href="">UK</a></li>
								</ul>
							</div>
							
							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
									DOLLAR
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<li><a href="">Canadian Dollar</a></li>
									<li><a href="">Pound</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-md-8 clearfix">
						<div class="shop-menu clearfix pull-right">
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-middle-->
		View name: {{$view_name}}