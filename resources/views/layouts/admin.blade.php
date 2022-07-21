<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <!--[if ie]><meta content='IE=8' http-equiv='X-UA-Compatible'/><![endif]-->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
    <!-- bootstrap -->
    <link href="{{asset ('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- scripts -->
    <script src="{{ asset ('js/jquery.js') }}"></script>
    <script src="{{ asset ('js/sweetalert.js') }}"></script>

    <!-- Custom styles for this template -->
    <link href="{{asset ('css/dashboard.css') }}" rel="stylesheet">
    <link href="{{asset ('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

  
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>


</head>

<body>

<nav style="padding: 0 10px 0 0; box-sizing: border-box;" class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">shop Mediolanum</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse" style="margin-right: initial;">

            <ul class="nav navbar-nav navbar-right">
                <li class="lang">
                    <a style="display: inline-block; padding: 15px 5px;" class="@if(App::getLocale() == 'en') active @endif " href="/{{ App::getLocale() }}/lang/en">En</a>
                    <a style="display: inline-block; padding: 15px 5px;" class="@if(App::getLocale() == 'ru') active @endif " href="/{{ App::getLocale() }}/lang/ru">Ru</a>
                </li>
                <li><a href="/{{ App::getLocale() }}/admin/products">Dashboard</a></li>
                <li><a href="#">Settings</a></li>
                <li><a href="#">Profile</a></li>
            </ul>

        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <div class="h2_like" style="">PRODUCTS</div>
                <li class="{{ (request()->is(App::getLocale() . '/admin/createProductForm')) ? 'active' : '' }}"><a href="/{{ App::getLocale() }}/admin/createProductForm">Add New Product</a></li>
                <li class="{{ (request()->is(App::getLocale() . '/admin/products')) ? 'active' : '' }}"><a href="{{route('adminDisplayProducts')}}">View Products<span class="sr-only">(current)</span></a></li>
                <hr>
                <div class="h2_like" style="">CATEGORIES</div>
                <div class="h3_like" style="">Women</div>
                <li class="{{ (request()->is(App::getLocale() . 'admin/add-women-category')) ? 'active' : '' }}"><a href="/{{ App::getLocale() }}/admin/add-women-category">Add New Women Category</a></li>
                <li class="{{ (request()->is(App::getLocale() . 'admin/view-women-categories')) ? 'active' : '' }}"><a href="/{{ App::getLocale() }}/admin/view-women-categories">View Women Categories</a></li>
               
                <div class="h3_like" style="">Men</div>
                <li class="{{ (request()->is(App::getLocale() . 'admin/add-category')) ? 'active' : '' }}"><a href="/{{ App::getLocale() }}/admin/add-category">Add New Men Category</a></li>
                <li class="{{ (request()->is(App::getLocale() . 'admin/view-categories')) ? 'active' : '' }}"><a href="/{{ App::getLocale() }}/admin/view-categories">View Men Categories</a></li>
                <hr>
                
                <div class="h2_like" style="">BRANDS</div>
                <li class="{{ (request()->is(App::getLocale() . 'admin/add-brand')) ? 'active' : '' }}"><a href="/{{ App::getLocale() }}/admin/add-brand">Add New Brand</a></li>
                <hr>
                <div class="h2_like" style="">COUPONS</div>
                <li class="{{ (request()->is(App::getLocale() . 'admin/add-coupon')) ? 'active' : '' }}"><a href="{{route('addCoupon')}}">Add Coupon</a></li>
                <li class="{{ (request()->is(App::getLocale() . 'admin/view-coupons')) ? 'active' : '' }}"><a href="{{route('viewCoupons')}}">View Coupons</a></li>
                <hr>
                <div class="h2_like" style="">ORDERS</div>
                <li class="{{ (request()->is(App::getLocale() . 'admin/ordersPanel')) ? 'active' : '' }}"><a href="{{route('ordersPanel')}}">View Orders</a></li>
                <hr>
                <div class="h2_like" style="">FRONT PAGE IMAGES</div>
                <li class="{{ (request()->is(App::getLocale() . 'admin/frontend-images')) ? 'active' : '' }}"><a href="{{route('frontend_add_image')}}">View/Add Images</a></li>

                
            </ul>
            <ul class="nav nav-sidebar">

            </ul>
            <ul class="nav nav-sidebar">

            </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <!-- <h1 class="page-header">Dashboard</h1> -->
View name: {{$view_name}}
            @yield('body')

        </div>
    </div>
</div>



<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
<script src="{{asset ('js/bootstrap.min.js') }}" ></script>
<script src="{{asset ('js/admin.js') }}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

</body>
</html>
