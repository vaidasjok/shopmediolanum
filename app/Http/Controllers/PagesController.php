<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FrontendImage;

class PagesController extends Controller
{
    public function front()
    {
    	$image_one = FrontendImage::where('type', 'one')->first();
    	$image_two_one = FrontendImage::where('type', 'two_one')->first();
    	$image_two_two = FrontendImage::where('type', 'two_two')->first();
    	$image_three = FrontendImage::where('type', 'three')->first();

    	return view('front', ['image_one' => $image_one, 'image_two_one' => $image_two_one, 'image_two_two' => $image_two_two]);
    }
}
