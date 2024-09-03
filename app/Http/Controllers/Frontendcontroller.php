<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Cart;
use App\Models\Category;
use App\Models\City;
use App\Models\Color;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\Inventory;
use App\Models\Offer;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Size;
use App\Models\SubText;
use App\Models\Tag;
use App\Models\Thumbnail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class Frontendcontroller extends Controller
{
    function welcome(){
        $categories= Category::all();
        $products =Product::take(8)->get();
        $recently_addeds =Product::latest()->take(3)->get();
        $banners = Banner::where('status',1)->get();
        $offers = Offer::where('status',1)->get();
        $subtext = SubText::all();
        return view('frontend.index',[
            'categories'=>$categories,
            'products'=> $products,
            'recently_addeds'=>$recently_addeds,
            'banners'=>$banners,
            'subtext'=>$subtext,
            'offers'=>$offers,
        ]);
    }

    function product_details($slug){
        $product = Product::where('slug',$slug)->get();
        $product_id = $product->first()->id;
        $product_info = Product::find($product_id);
        $galleries =Thumbnail::where('product_id',$product_id)->get();
        $available_colors =Inventory::where('product_id',$product_id)->groupBy('color_id')
        ->selectRaw('count(*) as total , color_id')->get();
        $available_sizes =Inventory::where('product_id',$product_id)->groupBy('size_id')
        ->selectRaw('count(*) as total , size_id')->get();
        $related_products =Product::where('category_id', $product_info->category_id)->where('id','!=', $product_id)->get();
        $reviews = OrderProduct::where('product_id',$product_id)->whereNotNull('review')->get();
        $total_star = OrderProduct::where('product_id',$product_id)->whereNotNull('review')->sum('star');

        $all = Cookie::get('recent_view');
        if (!$all) {
            $all = "[]";
        }
        $all_info = json_decode($all, true);
        $all_info = Arr::prepend($all_info, $product_id);
        $recent_product_id = json_encode($all_info);
        Cookie::queue('recent_view', $recent_product_id, 1000);

        return view('frontend.product_details',[
            'product_info'=>$product_info ,
            'galleries'=>$galleries,
            'available_colors'=>$available_colors,
            'available_sizes'=>$available_sizes,
            'related_products'=>$related_products,
            'reviews'=>$reviews,
            'total_star'=>$total_star,
        ]);
    }

    function getSizes(Request $request){
        $str = '';
        $sizes =Inventory::where('product_id',$request->product_id)->where('color_id',$request->color_id)->get();
        foreach ($sizes as  $size) {
            if ($size->rel_to_size->size_name == 'NA'){
                $str .= '<li class="color">
                <input checked class="sizes" id="sizes'.$size->size_id.'" type="radio" name="size_id" value="'.$size->size_id.'">
                <label for="sizes'.$size->size_id.'">'. $size->rel_to_size->size_name.'</label>
                </li>';
            }else {
                $str .= '<li class="color">
                <input class="sizes" id="sizes'.$size->size_id.'" type="radio" name="size_id" value="'.$size->size_id.'">
                <label for="sizes'.$size->size_id.'">'. $size->rel_to_size->size_name.'</label>
                </li>';
            }
        }
        echo $str;
    }

    function getStock(Request $request){
        $stock = Inventory::where('product_id',$request->product_id)->where('color_id',$request->color_id)->where('size_id',$request->size_id)->first()->quantity;
        $str = '<h3>Stock: '.$stock.'</h3>';
        echo $str;
    }

    function cart(Request $request){
        $coupon = $request->coupon;
        $msg = '';
        $type = '';
        $amount = '';
        if ($coupon != '') {
            if (Coupon::where('coupon_name',$coupon)->exists()) {
                if (Carbon::now() < Coupon::where('coupon_name',$coupon)->first()->validity) {
                    $type =  Coupon::where('coupon_name',$coupon)->first()->type;
                    $amount = Coupon::where('coupon_name',$coupon)->first()->amount;
                }else{
                    $msg = 'Coupon Expired';
                    $amount = 0;
                }
            }
            else{
                $msg = 'Invalid Coupon';
                $amount = 0;
            }
        }
        $carts =Cart::where('customer_id',Auth::guard('customer')->id())->get();
        return view('frontend.cart',[
            'carts'=>$carts,
            'msg'=>$msg,
            'amount'=> $amount,
            'type'=>$type,
        ]);
    }

    function checkout(){
        $countries = Country::all();
        $cities  = City::all();
        $carts =Cart::where('customer_id',Auth::guard('customer')->id())->get();

        return view('frontend.checkout',[
            'carts'=>$carts,
            'countries'=> $countries,
            'cities'=> $cities ,
        ]);
    }


    function shop(Request $request){
        $categories = Category::all();
        $colors = Color::all();
        $sizes = Size::all();
        $tags = Tag::all();

        $data = $request->all();

        $based = 'created_at';
        $type = 'DESC';

        if (!empty($data['sort']) && $data['sort'] != '' && $data['sort'] != 'undefined') {
            if($data['sort'] == 1){
                $based = 'price';
                $type = 'ASC';
            }else if($data['sort'] == 2){
                $based = 'price';
                $type = 'DESC';
            }else if($data['sort'] == 3){
                $based = 'product_name';
                $type = 'ASC';
            }else if($data['sort'] == 4){
                $based = 'product_name';
                $type = 'DESC';
            }
        }

        $products = Product::where(function($q) use ($data){
           $min = 1;
           $max = Inventory::max('after_discount');

            if(!empty($data['keyword']) && $data['keyword'] != '' && $data['keyword'] != 'undefined'){
                $q->where(function($q) use ($data){
                    $q->where('product_name', 'like', '%'.$data['keyword'].'%');
                    $q->orWhere('long_desp', 'like', '%'.$data['keyword'].'%');
                });
            }
            if(!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id'] != 'undefined'){
                $q->whereHas('rel_to_inventory',function($q) use ($data){
                    if(!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id'] != 'undefined') {
                       $q->whereHas('rel_to_color', function($q) use ($data){
                        $q->where('colors.id', $data['color_id']);
                       }) ;
                    }
                });
            }
            if(!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id'] != 'undefined' || !empty($data['size_id']) && $data['size_id'] != '' && $data['size_id'] != 'undefined'){
                $q->whereHas('rel_to_inventory',function($q) use ($data){
                    if(!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id'] != 'undefined') {
                       $q->whereHas('rel_to_color', function($q) use ($data){
                        $q->where('colors.id', $data['color_id']);
                       }) ;
                    }
                    if(!empty($data['size_id']) && $data['size_id'] != '' && $data['size_id'] != 'undefined') {
                        $q->whereHas('rel_to_size', function($q) use ($data){
                         $q->where('sizes.id', $data['size_id']);
                        }) ;
                     }
                });
            }

            if(!empty($data['category_id']) && $data['category_id'] != '' && $data['category_id'] != 'undefined'){
                $q->where(function($q) use ($data){
                $q->where('category_id', $data['category_id']);
                });
            }

            if(!empty($data['tag_id']) && $data['tag_id'] != '' && $data['tag_id'] != 'undefined'){
                $q->where(function($q) use ($data){
                    $all = '';
                    foreach(Product::all() as $product){
                        $explode = explode(',' , $product->tags);
                        if (in_array($data['tag_id'], $explode)) {
                            $all .= $product->id;
                        }
                    }
                    $explode2 = explode(',', $all);
                    $q->find($explode2);
                });
            }

            if(!empty($data['min']) && $data['min'] != '' && $data['min'] != 'undefined' || !empty($data['max']) && $data['max'] != '' && $data['max'] != 'undefined'){
                $q->whereHas('rel_to_inventory', function($q) use ($data){

                    $q->where(function($q) use ($data){
                        if(!empty($data['min']) && $data['min'] != '' && $data['min'] != 'undefined'){
                            $min = $data['min'];
                            }
                        if(!empty($data['max']) && $data['max'] != '' && $data['max'] != 'undefined'){
                            $max = $data['max'];
                        }
                        $q->whereBetween('after_discount', [$min, $max]);
                });
                });
            }
        })->orderBy($based, $type)->get();

        return view('frontend.shop',[
            'categories'=> $categories,
            'colors'=> $colors,
            'sizes'=> $sizes,
            'tags'=> $tags,
            'products'=>$products,
        ]);
    }

    function recent_views(){
        $recent_info = json_decode(Cookie::get('recent_view'),true);
        $recent_viewed ='';
        if($recent_info == Null){
            $recent_viewed = [];
        }else{
            $recent_viewed =array_unique($recent_info);
            $recent_viewed = array_reverse($recent_info);
        }
        $recent_viewed = Product::find($recent_viewed);
        return view('frontend.recent_views', [
            'recent_viewed'=>$recent_viewed
        ]);
    }
}
