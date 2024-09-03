<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerEmailVerify;
use App\Notifications\CustomerMailVerifyNotifiaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

use function Ramsey\Uuid\v1;
use function Symfony\Component\String\b;

class CustomerAuthController extends Controller
{
    function customer_login(){
        return view('frontend.customer_login');
    }

    function customer_register(){
        return view('frontend.customer_register');
    }

    function mail_verify_req(){
        return view('frontend.customer.mail_verify_req');
    }

    function mail_verify_req_send(Request $request){
        $customer = Customer::where('email',$request->email)->first();
        CustomerEmailVerify::where('customer_id',$customer->id)->delete();

        $info = CustomerEmailVerify::create([
            'token'=>uniqid(),
            'customer_id'=>$customer->id,
        ]);
        Notification::send($customer, new CustomerMailVerifyNotifiaction($info));
        return back()->with('verify_email','Verification Email Sent!! Please Verify Your Mail');
    }

    function customer_store(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'password'=>'required|confirmed',
            'password_confirmation'=>'required',
        ]);

        $customer_info = Customer::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
            'created_at'=>Carbon::now(),
        ]);

        $info =CustomerEmailVerify::create([
            'token'=>uniqid(),
            'customer_id'=>$customer_info->id,
        ]);
        Notification::send($customer_info, new CustomerMailVerifyNotifiaction($info));

        // if(Auth::guard('customer')->attempt(['email'=>$request->email, 'password'=>$request->password])){
        //     return redirect('/');
        // }

        return back()->with('registered','Customer Registration Successfully done, Please Verify Your Mail');
    }

    function customerlogin(Request $request){
        $request->validate([
                    'email'=>'required',
                    'password'=>'required',
                ]);
        if(Customer::where('email',$request->email)->exists()){
            if(Auth::guard('customer')->attempt(['email'=>$request->email, 'password'=>$request->password])){
                if (Auth::guard('customer')->user()->email_verified_at == null) {
                    Auth::guard('customer')->logout();
                    return back()->with('not_verified', 'Please Verify Your Email.');
                }else{
                return redirect('/');
                }
            }
            else{
                return back()->with('pass','Wrong Password');
            }
        }else{
            return back()->with('email','Email does not exists');
        }
    }
    // function customerlogin(Request $request){
    //     $request->validate([
    //         'email'=>'required',
    //         'password'=>'required',
    //     ]);
    //     if (Auth::guard('customer')->attempt(['email'=>$request->email, 'password'=>$request->password])) {
    //         return redirect('/');
    //     }else{
    //         return back()->with('email','Email does not exists');
    //     }
    // }

    function customer_logout(){
        Auth::guard('customer')->logout();
        return redirect()->route('customer.login');
    }

}
