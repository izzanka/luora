<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vote;
use App\Models\Topic;
use App\Models\Answer;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index(Request $request)
    {   
        $answers = Answer::with(['user','question'])->where('user_id','!=',auth()->id())->latest()->paginate(10);
        $credential = "";
        $data = "";
    
        if($request->ajax()){
           
            foreach($answers as $answer){
                //count view
                views($answer)
                ->cooldown(86400)
                ->record();
                //count question
                views($answer->question)
                ->cooldown(86400)
                ->record();

                //set share
                $link = route('question.show',$answer->question);
                $facebook = \Share::page($link)->facebook()->getRawLinks();
                $twitter = \Share::page($link)->twitter()->getRawLinks();

                //set credential
                if($answer->user->credential){
                    $credential = $answer->user->credential;
                }else{
                    $answer->user->load(['employment','education','location']);
                    if($answer->user->employment){
                        $end = $answer->user->employment->currently ? 'present' : $answer->user->employment->end_year;
                        $credential = $answer->user->employment->position . ' at ' . $answer->user->employment->company . ' (' . $answer->user->employment->start_year . '-' . $end . ')';
                    }else{
                        if($answer->user->education){
                            $end2 = $answer->user->education->graduation_year ? ' (Graduated ' . $answer->user->education->graduation_year . ')' : null;
                            $credential = $answer->user->education->degree_type . ' in ' . $answer->user->education->primary . ', ' . $answer->user->education->school . $end2;
                        }else{
                            if($answer->user->location){
                                $end3 = $answer->user->location->currently ? 'present' : $answer->user->location->end_year;
                                $credential = 'Lives in ' . $answer->user->location->location . ' (' . $answer->user->location->start_year . '-' . $end3 . ')';
                            }
                        }
                    }
                }

                //set vote status
                if(auth()->user()->hasUpVoted($answer)){
                    $upvoted = "-fill";
                }else{
                    $upvoted = "";
                }

                if(auth()->user()->hasDownVoted($answer)){
                    $downvoted = "-fill";
                }else{
                    $downvoted = "";
                }

                //set follow status
                if(auth()->user()->isFollowing($answer->user)){
                    $status = '<a href="'. route('follow',$answer->user->name_slug) .'">Following</a>';
                }else{
                    if(auth()->id() == $answer->user->id){
                        $status = '';
                    }else{
                        $status = '<a href="'. route('follow',$answer->user->name_slug) .'">Follow</a>';
                    }
                }
                
                $data .= '
                <div class="card mt-3" id="'. $answer->user->name_slug .'">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row mb-3">
                                    <div class="col-sm-1">
                                        <img src="' . $answer->user->avatar . '" alt="avatar" class="rounded-circle" width="42px" height="42px">
                                    </div>
                                   
                                    <div class="col-sm-11">
                                        <a href="'. route('profile.show',$answer->user->name_slug) .'" class="text-dark"><b>' . $answer->user->name .'</b></a> &#183; 
                                        '. $status .'
                                        <a href="" class="text-dark float-right dropdown-toogle" id="navbarDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre><i class="bi bi-three-dots" style="font-size: 20px"></i></a><br>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item">
                                                Bookmark
                                                </a>
                                                <a class="dropdown-item">
                                                    Report
                                                </a>
                                                <a class="dropdown-item">
                                                    Hide
                                                </a>
                                        </div>
                                            '. $credential .'  &#183; '. $answer->created_at->format('M d Y') .'
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <a href="'. route('question.show',$answer->question->title_slug) .'" class="text-dark"><h5><b>'. $answer->question->title .'</b></h5></a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        '. $answer->text .'<br>
                                        <small class="text-secondary">'. views($answer)->count() .' views</small>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="btn-group" role="group">
                                            <a href="'.route('answer.vote',['question' => $answer->question->title_slug,'answer' => $answer->id, 'vote' => 'upvote']).'" class="text-success mr-2" ><i class="bi bi-arrow-up-circle'.$upvoted.'"></i> '. $answer->upVoters()->count().'</a>
                                            <a href="'.route('answer.vote',['question' => $answer->question->title_slug,'answer' => $answer->id, 'vote' => 'downvote']).'" class="text-danger mr-4" ><i class="bi bi-arrow-down-circle'.$downvoted.'"></i> '. $answer->downVoters()->count().'</a>
                                            <a href="" class="text-secondary"><i class="bi bi-chat"></i> 0</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="btn-group float-right" role="group">
                                        <a href="" class="text-dark" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="bi bi-share"></i></a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <a class="dropdown-item" href="'. $facebook . '#'.$answer->user->name_slug.''. '" target="_blank"><i class="bi bi-facebook mr-2"></i>Facebook</a>
                                                <a class="dropdown-item" href="'. $twitter . '#'.$answer->user->name_slug.''.'" target="_blank"><i class="bi bi-twitter mr-2"></i>Twitter</a>
                                                <a class="dropdown-item" href="javascript: void(0)" onclick="copy()" id="copyLink" data-attr="'. $answer->question->title_slug .'#'. $answer->user->name_slug.'">Copy link</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                ';
            }

            return $data;
        }

        return view('home');
    }

    public function search(Request $request){
        
        $users = [];

        if($request->has('q')){
            $search = $request->q;
            $users = User::select('id','name_slug','name')->where('id','!=',auth()->id())->where('name','LIKE', "%$search%")->get();
        }

        return response()->json($users);
    }
}
