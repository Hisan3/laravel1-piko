<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\Customer;
use App\Models\CustomerEmailVerify;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\PassReset;
use App\Notifications\PassResetNotification;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use PDF;
use Illuminate\Support\Facades\Notification;

class CustomerController extends Controller
{
    function customer_profile(){
        return view('frontend.profile');
    }

    function customer_update(Request $request){
        $photo = $request->photo ;
        if ($request->password != '') {
            if ($photo != '') {
                if (Auth::guard('customer')->user()->photo != null) {
                   $delete_from = public_path('uploads/customer/'.Auth::guard('customer')->user()->photo );
                   unlink($delete_from);
                }

                $extension = $photo->extension();
                $file_name = Auth::guard('customer')->id().'.'.$extension;
                Image::make($photo)->save(public_path('uploads/customer/'.$file_name));
                 Customer::find(Auth::guard('customer')->id())->update([
                     'name'=>$request->name,
                     'email'=>$request->email,
                     'password'=>bcrypt($request->password),
                     'photo'=>$file_name,
                     'country'=>$request->country,
                     'city'=>$request->city,
                     'address'=>$request->address,
                     'zip'=>$request->zip,
                 ]);
                return back();
            }else{
                Customer::find(Auth::guard('customer')->id())->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'password'=>bcrypt($request->password),
                    'country'=>$request->country,
                    'city'=>$request->city,
                    'address'=>$request->address,
                    'zip'=>$request->zip,
                ]);
                return back();
            }
        }else{
            if ($photo != '') {
                if (Auth::guard('customer')->user()->photo != null) {
                    $delete_from = public_path('uploads/customer/' . Auth::guard('customer')->user()->photo);
                    unlink($delete_from);
                 }
                $extension = $photo->extension();
                $file_name = Auth::guard('customer')->id().'.'.$extension;
                Image::make($photo)->save(public_path('uploads/customer/'.$file_name));
                 Customer::find(Auth::guard('customer')->id())->update([
                     'name'=>$request->name,
                     'email'=>$request->email,
                     'photo'=>$file_name,
                     'country'=>$request->country,
                     'city'=>$request->city,
                     'address'=>$request->address,
                     'zip'=>$request->zip,
                 ]);
                 return back();

            }else{
                Customer::find(Auth::guard('customer')->id())->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'country'=>$request->country,
                    'city'=>$request->city,
                    'address'=>$request->address,
                    'zip'=>$request->zip,
                ]);
                return back();
            }
        }
    }

    function my_order(){
        $myorders = Order::where('customer_id',Auth::guard('customer')->id())->latest()->get();
        return view('frontend.customer.my_order',[
            'myorders'=>$myorders,
        ]);
    }

    function download_invoice($id){
        $order_info = Order::find($id);
        $billing_info = Billing::where('order_id',$order_info->order_id)->first();
        $orderproducts = OrderProduct::where('order_id',$order_info->order_id)->get();

        $pdf = PDF::loadView('frontend.customer.invoice', [
            'order_info' => $order_info,
            'billing_info' => $billing_info,
            'orderproducts' => $orderproducts,
        ]);

        return $pdf->download('invoice.pdf');
    }

    function pass_reset_req(){
        return view('frontend.customer.pass_reset_req');
    }

    function pass_reset_req_send(Request $request){
        $customer =Customer::where('email', $request->email)->first();
        if(Customer::where('email', $request->email)->exists()){
            PassReset::where('customer_id',$customer->id)->delete();
            $info = PassReset::create([
                'token'=>uniqid(),
                'customer_id'=>$customer->id,
            ]);
            Notification::send($customer, new PassResetNotification($info));
            return back()->with('success', 'Password Rest Link Sent to your Email');
        }else{
            return back()->with('invalid', 'Invalid Address');
        }
    }

    function pass_reset_form($token){
        if (PassReset::where('token',$token)->exists()) {
            return view('frontend.customer.pass_reset_form', [
                'token'=>$token,
            ]);
        }else{
            abort('404');
        }
    }

    function pass_reset_update(Request $request ,$token){
        $info = PassReset::where('token', $token)->first();
        if (PassReset::where('token', $token)->exists()) {
            $request->validate([
                'password'=>'required|confirmed',
                'password_confirmation'=>'required',
            ]);
            Customer::find($info->customer_id)->update([
                'password'=>bcrypt($request->password),
            ]);

            PassReset::where('token', $token)->delete();

            return redirect()->route('customer.login')->with('success','Password Updated');
        }else{
            abort('404');
        }
    }

    function customer_mail_verify($token){
       $customer = CustomerEmailVerify::where('token', $token)->first();

       if (CustomerEmailVerify::where('token',$token)->exists()) {
       Customer::find($customer->customer_id)->update([
        'email_verified_at'=> Carbon::now(),
       ]);
       CustomerEmailVerify::where('token', $token)->delete();

       return redirect()->route('customer.login')->with('verified','Email Verified Successfully');
    }else{
        abort('404');
    }
    }

}
