<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    function user_edit(){
        return view('backend.user.edit');
    }

    function user_update(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
        ],[
            'name.required'=>'Please fill this box',
        ]);

        User::find(Auth::id())->update([
            'name'=>$request->name,
            'email'=>$request->email,
        ]);
        return back()->with('success','User Updated');
    }

    function password_update(Request $request){
        $request->validate([
            'current_password'=>'required',
            'password'=>['required', 'confirmed'],
            'password_confirmation'=>'required',
            'password'=>Password::min(8)
            ->letters()
            ->mixedCase()
            ->numbers()
            ->symbols()
         ]);

         if (password_verify($request->current_password, Auth::user()->password)) {
            User::find(Auth::id())->update([
                'password'=>bcrypt($request->password),
            ]);
            return back()->with('pass_update','Password Updated');

         }else{
            return back()->with('curnt','Current password does not match');
         }
        }

        function user_photo_update(Request $request){
            $request->validate([
                'profile_photo'=>'required',
                'profile_photo'=>'mimes:jpg,bmp,png,jpeg',
                'profile_photo'=>'max:1024'
            ]);

            if(Auth::user()->image != null){
                $delete_from = public_path('uploads/user/'.Auth::user()->image);
                unlink($delete_from);
            }
            $photo = $request->profile_photo;
            $extension = $photo->extension();
            $file_name = Auth::id().'.'.$extension;
            Image::make($photo)->resize(300, 200)->save(public_path('uploads/user/'.$file_name));
            User::find(Auth::id())->update([
                'image'=>$file_name,
            ]);
            return back()->with('photo_update','Profile Photo Updated');
        }

        function user_list(){
            $users =User::all();
            return view('backend.user.user_list',[
                'users'=> $users,
            ]);
        }

        function user_delete($id){
            User::find($id)->delete();
            return back()->with('del','Id deleted');
        }
}
