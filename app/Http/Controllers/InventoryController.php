<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Inventory;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Size;
use Carbon\Cli\Invoker;

class InventoryController extends Controller
{
   function add_variation(){
    $colors =Color::all();
    $sizes =Size::all();
    return view('backend.product.variation',[
        'colors'=>$colors,
        'sizes'=>$sizes,
    ]);
   }

   function color_store(Request $request){
    Color::insert([
        'color_name'=>$request->color_name,
        'color_code'=>$request->color_code,
        'created_at'=>Carbon::now(),
    ]);
    return back();
   }

   function color_delete($id){
    Color::find($id)->delete();
    return back();
   }

   function size_delete($id){
    Color::find($id)->delete();
    return back();
   }

   function size_store(Request $request){
    Size::insert([
        'size_name'=>$request->size_name,
        'created_at'=>Carbon::now(),
    ]);
    return back();
   }

   function inventory($id){
    $product =Product::find($id);
    $colors =Color::all();
    $sizes =Size::all();
    $inventories =Inventory::where('product_id',$id)->get();
    return view('backend.product.inventory',[
        'colors'=>$colors,
        'sizes'=>$sizes,
        'product'=> $product,
        'inventories'=>$inventories,
    ]);
   }

   function inventory_store(Request $request ,$id){

    if (Inventory::where('product_id',$id)->where('color_id',$request->color_id)->where('size_id',$request->size_id)->exists()){
        Inventory::where('product_id',$id)->where('color_id',$request->color_id)->where('size_id',$request->size_id)->increment('quantity',$request->quantity);
        return back();
    }else{
        $product =Product::find($id);
        Inventory::insert([
            'product_id'=>$id,
            'color_id'=>$request->color_id,
            'size_id'=>$request->size_id,
            'quantity'=>$request->quantity,
            'price'=>$request->price,
            'after_discount'=>$request->price - $request->price*$product->discount/(100),
            'created_at'=>Carbon::now(),
        ]);
        return back();
    }
   }

   function inventory_delete($id){
    Inventory::find($id)->delete();
    return back();
   }

}
