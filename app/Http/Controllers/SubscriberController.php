<?php

namespace App\Http\Controllers;

use App\Models\SubscriberList;
use App\Models\SubText;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class SubscriberController extends Controller
{
    function edit_subscriber(){
        $sub_texts = SubText::all();
        $subscriber_lists =SubscriberList::all();
        return view('backend.subscriber.subscriber',[
            'sub_texts'=>$sub_texts,
            'subscriber_lists'=>$subscriber_lists,
        ]);
    }

    function subtext_update(Request $request,$id){
        SubText::find($id)->update([
            'text'=>$request->text,
        ]);
        return back();
    }

    function subscriber_store(Request $request){
        SubscriberList::insert([
            'email'=>$request->email,
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('subscribed' ,'You have successfully subscribed');
    }

    function subscriber_delete($id){
        SubscriberList::find($id)->delete();
        return back();
    }
}
