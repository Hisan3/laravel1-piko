<?php

namespace App\Http\Controllers;

use App\Models\StripeOrder;
use Illuminate\Http\Request;
use Session;
use Stripe;
use App\Models\Sslorder;
use App\Mail\InvoiceMail;
use App\Models\City;
use App\Models\Billing;
use App\Models\Cart;
use App\Models\Inventory;
use App\Models\Shipping;
use App\Models\Order;
use App\Models\OrderProduct;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        $data = session('data');
        $id =  StripeOrder::insertGetId([
            'customer_id' => $data['customer_id'],
            'total' => $data['sub_total'] + $data['charge'] ,
            'discount' => $data['discount'],
            'charge' => $data['charge'],
            'fname' => $data['fname'],
            'lname' => $data['lname'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'country_id' => $data['country_id'],
            'city_id' => $data['city_id'],
            'zip' => $data['zip'],
            'company' => $data['company'],
            'notes' => $data['notes'],
            'shipping_fname' => $data['shipping_fname'],
            'shipping_lname' => $data['shipping_lname'],
            'shipping_country_id' => $data['shipping_country_id'],
            'shipping_city_id' => $data['shipping_city_id'],
            'shipping_zip' => $data['shipping_zip'],
            'shipping_company' => $data['shipping_company'],
            'shipping_email' => $data['shipping_email'],
            'shipping_phone' => $data['shipping_phone'],
            'shipping_address' => $data['shipping_address'],
            'ship_check' => $data['ship_check'],
        ]);

        $ttal = $data['sub_total'] + $data['charge'];

        return view('frontend.stripe',[
            'id' => $id,
            'total'=> $ttal,
        ]);
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request , $id)
    {
        $data = StripeOrder::find($id);
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        Stripe\Charge::create ([
                "amount" => 100 * $data->total,
                "currency" => "bdt",
                "source" => $request->stripeToken,
                "description" => "Test payment from itsolutionstuff.com."
        ]);

        $order_id='order'.'-'.random_int(10000000,90000000);
        Order::insert([
            'customer_id'=>$data->customer_id,
            'order_id'=>$order_id,
            'discount'=>$data->discount,
            'charge'=>$data->charge,
            'total'=>$data->total,
            'created_at'=>Carbon::now(),
        ]);

        Billing::insert([
            'customer_id'=>$data->customer_id,
            'order_id'=>$order_id,
            'fname'=>$data->fname,
            'lname'=>$data->lname,
            'country_id'=>$data->country_id,
            'city_id'=>$data->city_id,
            'zip'=>$data->zip,
            'company'=>$data->company,
            'email'=>$data->email,
            'phone'=>$data->phone,
            'address'=>$data->address,
            'notes'=>$data->notes,
            'created_at'=>Carbon::now(),
        ]);
        if ($data->ship_check == 1) {
            Shipping::insert([
                'customer_id'=>$data->customer_id,
                'order_id'=>$order_id,
                'shipping_fname'=>$data->shipping_fname,
                'shipping_lname'=>$data->shipping_lname,
                'shipping_country_id'=>$data->shipping_country_id,
                'shipping_city_id'=>$data->shipping_city_id,
                'shipping_zip'=>$data->shipping_zip,
                'shipping_company'=>$data->shipping_company,
                'shipping_email'=>$data->shipping_email,
                'shipping_phone'=>$data->shipping_phone,
                'shipping_address'=>$data->shipping_address,
                'created_at'=>Carbon::now(),
            ]);
        }

        $carts = Cart::where('customer_id',$data->customer_id)->get();
        foreach ($carts as $cart) {
            OrderProduct::insert([
                'customer_id'=>$data->customer_id,
                'order_id'=>$order_id,
                'product_id'=>$cart->product_id,
                'price'=>$cart->rel_to_inventory->where('product_id',$cart->product_id)->where('color_id',$cart->color_id)->where('size_id',$cart->size_id)->first()->after_discount ,
                'color_id'=>$cart->color_id,
                'size_id'=>$cart->size_id,
                'quantity'=>$cart->quantity,
                'created_at'=>Carbon::now(),
            ]);
            Inventory::where('product_id',$cart->product_id)->where('color_id',$cart->color_id)->where('size_id',$cart->size_id)->decrement('quantity',$cart->quantity);

            $carts->find($cart->id)->delete();
        }

        //sending invoice mail
        Mail::to($data->email)->send(new InvoiceMail($order_id));

        return redirect()->route('order.success');


}
}
