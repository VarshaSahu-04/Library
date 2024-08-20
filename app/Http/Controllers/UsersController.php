<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Phone;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreUserRequest;


class UsersController extends Controller
{


Public function Users(){
    
    $users=Users::get();
    
   
    return view('userslist', ['data' => $users]);

}

Public function add(Request $request){
    $validator = Validator::make($request->all(), [
        'name' => ['required', 'string', 'regex:/^[\pL\s\-]+$/u'],
        'email' => ['required', 'email', 'unique:users'],
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $user = Users::create([
        'name' => $request->name,
        'email' =>$request->email,
        'password'=>'hello',
        'created_at'=>now()      
    ]);

    return redirect()->route('student'); 


}

}