<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    function brand(){
        $brands =Brand::all();
        return view('backend.brand.brand',[
            'brands'=> $brands,
        ]);
    }

    function brand_store(Request $request){
        $request->validate([
            'brand_name'=>'required',
            'brand_logo'=>['required','mimes:png,jpg,jpeg,gif','max:1800'],
        ]);

        $logo = $request->brand_logo;
        $extension = $logo->extension();
        $file_name = uniqid().'.'.$extension;
        Image::make($logo)->resize(300,200)->save(public_path('uploads/brand/'.$file_name));

        $slug =Str::lower(str_replace(' ','-',$request->brand_name)).'-'.random_int(10000000,99999999);

        Brand::insert([
            'brand_name'=>$request->brand_name,
            'brand_logo'=>$file_name,
            'brand_slug'=>$slug,
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('success','Brand Added Successfully');
    }

    function brand_delete($id){
        $brand = Brand::find($id);

        $del_from =public_path('uploads/brand/'.$brand->brand_logo);
        unlink($del_from);

        Brand::find($id)->delete();

        return back();
    }
}
