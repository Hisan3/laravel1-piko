<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

use function Ramsey\Uuid\v1;

class SubCategorController extends Controller
{
    function subcategory(){
        $categories = Category::all();
        $subcategories = SubCategory::all();
        return view('backend.category.subcategory',[
            'categories'=>$categories,
            'subcategories'=>$subcategories,
        ]);

    }

    function subcategory_store(Request $request){
    $request->validate([
        'category_id'=>'required',
        'subcategory_name'=>'required',
    ],[
        'category_id.required'=>'Category Name is Required',
    ]);
    if (SubCategory::where('category_id', $request->category_id)->where('subcategory_name',$request->subcategory_name)->exists()) {
        return back()->with('exists','Subcategory Name Already Exists');
    }else{
        SubCategory::insert([
            'category_id'=>$request->category_id,
            'subcategory_name'=>$request->subcategory_name,
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('success','SubCategory Added');
        }
    }

    function edit_subcategory($id){
        $categories =Category::all();
        $subcategory_info =SubCategory::find($id);
        return view('backend.category.edit_subcategory',[
            'categories'=>$categories,
            'subcategory_info'=>$subcategory_info,
        ]);
    }

    function subcategory_update(Request $request ,$id){
        SubCategory:: find($id)->update([
            'category_id'=>$request->category_id,
            'subcategory_name'=>$request->subcategory_name,
            'updated_at'=>Carbon::now(),
        ]);
        return back();
    }

    function delete_subcategory($id){
        SubCategory::find($id)->delete();
        return back();
    }

}
