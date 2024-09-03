<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Support\Str;

use Illuminate\Http\Request;

class TagController extends Controller
{
    function tags(){
        $tags =Tag::paginate(5); //simple paginate
        return view('backend.tag.tags',[
            'tags'=>$tags,
        ]);
    }

    function tag_store(Request $request){
        $request->validate([
            'tag_name'=>'required|unique:tags',
        ]);
        $slug =Str::lower(str_replace(' ','-',$request->tag_name)).'-'.random_int(10000000,99999999);

        Tag::insert([
            'tag_name'=>$request->tag_name,
            'tag_slug'=>$slug,
            'created_at'=>Carbon::now(),
        ]);

        return back()->with('success', 'Tag Added ');
    }

    function tag_delete($id){
        Tag::find($id)->delete();
        return back();
    }
}
