<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\Tag;
use App\Models\Thumbnail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class Productcontroller extends Controller
{
    function add_product(){
        $categories =Category::all();
        $subcategories=SubCategory::all();
        $brands=Brand::all();
        $tags=Tag::all();

        return view('backend.product.add_product',[
            'categories'=>$categories,
            'subcategories'=>$subcategories,
            'brands'=>$brands,
            'tags'=>$tags,
        ]);
    }

    function getsubcategory(Request $request){
        $subcategories = SubCategory::where('category_id',$request->category_id)->get();
        $sub ='<option value="">Select SubCategory</option>';
        foreach ($subcategories as  $subcategory) {
            $sub .= '<option value="'.$subcategory->id.'">'.$subcategory->subcategory_name.'</option>';
        }
        echo $sub;
    }

    function product_store(Request $request){
        $after_implode_tag = implode(',',$request->tag_id);
        $slug =Str::lower(str_replace(' ','-',$request->product_name)).'-'.random_int(10000000,99999999);

        $preview = $request->preview;
        $extension =$preview->extension();
        $file_name =uniqid().'.'.$extension;
        Image::make($preview)->resize(700,700)->save(public_path('uploads/product/preview/'.$file_name));

         $product_id = Product::insertGetId([
            'category_id'=>$request->category_id,
            'subcategory_id'=>$request->subcategory_id,
            'brand_id'=>$request->brand_id,
            'product_name'=>$request->product_name,
            'discount'=>$request->discount,
            'short_desp'=>$request->short_desp,
            'long_desp'=>$request->long_desp,
            'additional_info'=>$request->additional_info,
            'tags'=>$after_implode_tag,
            'slug'=>$slug,
            'preview'=>$file_name,
            'created_at'=>Carbon::now(),
        ]);

        $thumbnails = $request->thumbnails;
        foreach ($thumbnails as $thumb) {
            $slug2 =Str::lower(str_replace(' ','-',$request->product_name)).'-'.random_int(10000000,99999999);
            $extension2 = $thumb->extension();
            $file_name2 = $slug2. '.' . $extension2;
            Image::make($thumb)->resize(700,700)->save(public_path('uploads/product/thumbnail/'.$file_name2));
            Thumbnail::insert([
                'product_id'=>$product_id,
                'thumbnail'=>$file_name2,
                'created_at'=>Carbon::now(),
            ]);
        }

        return back()->with('success', 'Product Added Successfully');
    }

    function product_list(){
        $products = Product::all(); //latest()->get()
        return view('backend.product.list',[
            'products'=> $products,
        ]);
    }

    function product_view($id){
        $product =Product::find($id);
        return view('backend.product.view',[
            'product'=>$product,
        ]);
    }

    function product_delete($id){
        $product =Product::find($id);
        $preview_delete_from = public_path('uploads/product/preview/'.$product->preview);
        unlink($preview_delete_from);

        $galleries =Thumbnail::where('product_id',$id)->get();
        foreach($galleries as $gal){
            $gallery_delete_from = public_path('uploads/product/thumbnail/'.$gal->thumbnail);
            unlink($gallery_delete_from);
            Thumbnail::find($gal->id)->delete();
        }

        Product::find($id)->delete();
        return back();
    }
}
