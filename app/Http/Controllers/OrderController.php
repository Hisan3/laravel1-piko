<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    function orders(){
        $orders = Order::latest()->get();
        return view('backend.order.orders',[
            'orders'=>$orders ,
        ]);
    }

    function change_order_status(Request $request, $id){
        Order::find($id)->update([
            'status'=>$request->status,
        ]);
        return back();
    }

    function review_store(Request $request, $product_id){
        OrderProduct::where('customer_id', Auth::guard('customer')->id())->where('product_id', $product_id)->update([
            'review'=>$request->review,
            'star'=>$request->stars,
        ]);
        return back();
    }
}
