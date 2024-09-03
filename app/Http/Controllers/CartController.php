<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    function add_cart(Request $request, $product_id){
        Cart::insert([
            'customer_id'=>Auth::guard('customer')->id(),
            'product_id'=>$product_id,
            'color_id'=>$request->color_id,
            'size_id'=>$request->size_id,
            'quantity'=>$request->quantity,
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('cart_added', "Added to Cart Successfully!!");
    }

    function cart_remove($cart_id){
        Cart::find($cart_id)->delete();
        return back();
    }

    function cart_update(Request $request){
      foreach ($request->quantity as $cart_id => $cart) {
        Cart::find($cart_id)->update([
            'quantity'=>$cart,
        ]);
      }
      return back();
    }
}
