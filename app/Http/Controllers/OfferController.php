<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Carbon;

class OfferController extends Controller
{
    function add_offer(){
        $offers = Offer::all();
        return view('backend.banner.offer',[
            'offers'=>$offers,
        ]);
    }

    function offer_store(Request $request){
        $offer_img = $request->offer_img;
        $extension =$offer_img->extension();
        $file_name =uniqid().'.'.$extension;
        Image::make($offer_img)->save(public_path('uploads/offer/'.$file_name));

        offer::insert([
            'title'=>$request->title,
            'offer_img'=>$file_name,
            'created_at'=>Carbon::now(),
        ]);
        return back();
       }


   function offer_status($id){
    $offer=Offer::find($id);
    if ($offer->status == 0) {
        Offer::find($id)->update([
            'status'=>1,
        ]);
        return back();
    }else{
        Offer::find($id)->update([
        'status'=>0,
    ]);
    return back();
    }
    }

    function offer_delete($id){
        $offer =Offer::find($id);
        $del_from = public_path('uploads/offer/'.$offer->offer_img);
        unlink($del_from);

        Offer::find($id)->delete();

        return back();

    }
}
