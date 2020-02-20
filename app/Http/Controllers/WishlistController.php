<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Wishlist;
use Session;

class WishlistController extends Controller
{
    public function addRemoveProductToList(Request $request, $id) {
        // $request->session()->flush();

        $prevList = Session::get('wishlist');

        $wishlist = new Wishlist($prevList);

        $wishlist->addRemoveItem($id);
        $request->session()->put('wishlist', $wishlist);

        return redirect()->back();
    }

    public function viewWishlist()
    {
    	$ids = Session::get('wishlist')->getList();
    	$array = Session::get('wishlist')->getListArray();
    	return view('wishlist', ['ids' => $ids, 'array' => $array]);
    }
}
