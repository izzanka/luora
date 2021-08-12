<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function index(){
        return view('user.setting.index');
    }

    public function update_password(Request $request,User $user){
        
        if($user->id != auth()->id()){
            return back();
        }  
    
        $request->validate([
            'password' => 'required|string|min:8'
        ]);

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('message',['text' =>  'Profile password updated successfully!', 'class' => 'success']);
       
    }
}
