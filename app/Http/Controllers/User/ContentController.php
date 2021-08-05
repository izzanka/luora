<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContentController extends Controller
{
    
    public function index(){
        $user = User::with(['questions','answers'])->find(auth()->id());
        $contents = $user->getContents();
     
        // foreach($contents as $content){
        //     echo $content->title;
        //    foreach($content->answers as $answer){
        //        echo $answer->text;
        //    }
        // }
        return view('user.content.index',compact('contents'));
    }

    public function questions(){
        $user = User::find(auth()->id());
        return view('user.content.index',compact('user'));

        // $data = "";   
        // if($request->ajax()){
        //     foreach($user->questions as $question){
        //         $data .= '
        //         <div class="row q">
        //             <div class="col-12">
        //                 <a href="">'. $question->title .'</a><br>
        //                 <small class="text-secondary">Asked '. $question->created_at->format('M Y') .'</small>
        //             </div>
        //         </div>
        //         <hr>
        //         ';
        //     }
        //     return json_encode($user->questions);
        // }  
    }


    public function answers(){
        $user = User::find(auth()->id());
        $answers = $user->answers()->with('question')->get();

        return view('user.content.index',compact('answers'));

        // $data ='';
        // if($request->ajax()){
        //     foreach($user->answers as $answer){
        //         $data .= '
        //         <div class="row e">
        //             <div class="col-12">
        //                 <a href="">'. $answer->question->title .'</a><br>
        //                 <small class="text-secondary">Answered '. $answer->created_at->format('M Y') .'</small>
        //             </div>
        //         </div>
        //         <hr>
        //         ';
        //     }
        //     return json_encode($answers);
        // }
    }
}
