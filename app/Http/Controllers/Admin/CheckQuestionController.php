<?php

namespace App\Http\Controllers\Admin;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\QuestionTopic;
use App\Models\ReportQuestion;
use App\Http\Controllers\Controller;

class CheckQuestionController extends Controller
{
    public function index(){
        $questions = Question::doesnthave('report_users')->whereNull('status')->orWhere('status','updated_by_user')->with('user')->latest()->get();
        return view('admin.question.index',compact('questions'));
    }

    public function reported(){
        $questions = Question::has('report_users')->with(['report_users' => function($q){$q->distinct()->get();}])->withCount('report_users')->orderBy('report_users_count','desc')->get();
        return view('admin.question.index',compact('questions'));
    }

    public function update_status(Question $question,$status){

        if($status == 'viewed_by_admin' || 'deleted_by_admin'){

            $question->update([
                'status' => $status
            ]);

            if($status == 'deleted_by_admin'){

                $qtopics = QuestionTopic::where('question_id',$question->id)->get();

                foreach($qtopics as $qtopic){
                    $qtopic->delete();
                }
        
                foreach($question->answers as $answer){
                    $answer->delete();
                }
        
                $question->delete();
            }

        }else{

            return back();
            
        }

        return back()->with('message',['text' =>  'Question status updated successfully!', 'class' => 'success']);
    }
}
