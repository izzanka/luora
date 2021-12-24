<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Topic;
use App\Models\Answer;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {   
        $answers = Answer::with(['user','question'])->where('user_id','!=',auth()->id())
                   ->whereNull('status')->orWhere('status','viewed_by_admin')->orWhere('status','updated_by_user')
                   ->latest()->paginate(8);
        return view('home',compact('answers'));
    }

    //api search
    public function search(Request $request){
        
        $users = [];

        if($request->has('q')){
            $search = $request->q;
            $users = User::select('id','name_slug','name')->where('name','LIKE', "%$search%")->get();
        }

        return response()->json($users);
    }
}
