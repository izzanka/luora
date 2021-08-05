<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Topic;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AnswerController extends Controller
{

    public function index()
    {
   
        $questions = Question::where('user_id','!=',auth()->id())->latest()->take(10)->get();
        
        // $data = '';
        // if($request->ajax){
        //     foreach($questions as $question){
        //         $data .= '
        //         <div class="row">
        //         <div class="col-sm-12">
        //             <b>'. $question->title .'</b>
        //         </div>
        //     </div>
        //     <div class="row">
        //         <div class="col-sm-12"> 
        //             <a href="'. $question->qty ? $question->title_slug : 'unanswered/' . $question->title_slug .'"><b class="text-secondary">'. $question->qty ? $question->qty . ' answer' : 'No answer yet'.' </b></a> &#183; 
        //             '. 'last updated ' . $question->updated_at->diffForHumans() .'
        //         </div>
        //     </div>
        //     <div class="row mt-2">
        //         <div class="col-sm-6">
        //             <a href="" data-toggle="modal" data-target="#exampleModal2" data-attr="'. route('answer.store',$question->title_slug) .'" id="answer"><i class="bi bi-pencil-square"></i> Answer</a>
                    
        //             <!-- Modal -->
        //             <form action="" enctype="multipart/form-data" method="POST" id="store">
        //             @csrf
        //                 <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModal2Label" aria-hidden="true">
        //                     <div class="modal-dialog modal-dialog-centered modal-lg">
        //                     <div class="modal-content">
        //                         <div class="modal-header">
        //                         <h5 class="modal-title" id="exampleModal2Label">
        //                             <img src="'. Auth::user()->avatar .'" alt="avatar" class="rounded-circle mr-2" width="42px" height="42px">
        //                             '. Auth::user()->name .'
        //                         </h5>
        //                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        //                             <span aria-hidden="true">&times;</span>
        //                         </button>
        //                         </div>
                            
        //                             <div class="modal-body">
        //                                 <textarea id="summernote" name="text"></textarea>
        //                             </div>
                            
        //                         <div class="modal-footer">
        //                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        //                         <button type="submit" class="btn btn-primary store">Post</button>
        //                         </div>
        //                     </div>
        //                     </div>
        //                 </div>
        //             </form>
        //         </div>
        //     </div>
        //     <hr>
        //         ';
        //     }
        //     return $data;
        // }

        return view('user.answer.index',compact('questions'));
    }

    public function store(Request $request, Question $question)
    {
        $answer = Answer::where('question_id',$question->id)->where('user_id',auth()->id())->first();

        if($answer){
            return back()->with('message',['text' => 'U can only answer once !', 'class' => 'warning']);;
        }

        $request->validate([
            'text' => 'required'
        ]);

        Answer::create([
            'user_id' => auth()->id(),
            'question_id' => $question->id,
            'text' => $request->text,
        ]);

        return back()->with('message',['text' => 'Answer added successfully!', 'class' => 'success']);;
    }

    public function vote(Question $question,Answer $answer,$vote){
        $authUser = auth()->user();
        
        if($vote == "upvote"){
            if($authUser->hasUpVoted($answer)){
                $authUser->cancelVote($answer);
            }else{
                $authUser->upVote($answer);
            }
        }else if($vote == "downvote"){
            if($authUser->hasDownVoted($answer)){
                $authUser->cancelVote($answer);
            }else{
                $authUser->downVote($answer);
            }
        }
       
        return back();

    }

    public function update(Answer $answer,Request $request){
        $request->validate([
            'text' => 'required'
        ]);

        $answer->update([
            'text' => $request->text
        ]);

        return back()->with('message',['text' => 'Answer updated successfully!', 'class' => 'success']);
    }

    public function destroy(Answer $answer){
        $answer->delete();
        return back()->with('message',['text' => 'Answer deleted successfully!', 'class' => 'success']);
    }

}
