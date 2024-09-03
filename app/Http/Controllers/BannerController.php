<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class BannerController extends Controller
{
   function add_banner(){
    $banners =Banner::all();
    return view('backend.banner.add_banner',[
        'banners'=>$banners,
    ]);
   }

   function banner_store(Request $request){
    $banner_img = $request->banner_img;
    $extension =$banner_img->extension();
    $file_name =uniqid().'.'.$extension;
    Image::make($banner_img)->save(public_path('uploads/banner/'.$file_name));

    Banner::insert([
        'title'=>$request->title,
        'banner_img'=>$file_name,
        'created_at'=>Carbon::now(),
    ]);
    return back();
   }

   function banner_status($id){
    $banner =Banner::find($id);
    if ($banner->status == 0) {
        Banner::find($id)->update([
            'status'=>1,
        ]);
        return back();
    }else{
        Banner::find($id)->update([
        'status'=>0,
    ]);
    return back();
    }
    }

    function banner_delete($id){
        $banner =Banner::find($id);
        $del_from = public_path('uploads/banner/'.$banner->banner_img);
        unlink($del_from);

        Banner::find($id)->delete();

        return back();

    }

}
