<?php

namespace App\Http\Controllers\Admin;

use App\Models\Answer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CheckAnswerController extends Controller
{
    public function index(){
        $answers = Answer::doesnthave('report_users')->whereNull('status')->orWhere('status','updated_by_user')->latest()->get();
        return view('admin.answer.index',compact('answers'));
    }

    public function reported(){
        $answers = Answer::has('report_users')->with(['report_users' => function($q){$q->distinct()->get();}])->withCount('report_users')->orderBy('report_users_count','desc')->get();
        return view('admin.answer.index',compact('answers'));
    }

    public function update_status(Answer $answer,$status){

        if($status == 'viewed_by_admin' || 'deleted_by_admin'){

            if($status == 'deleted_by_admin'){
                $answer->delete();
            }else{
                $answer->update([
                    'status' => $status
                ]);
            }

        }else{
            return back();
        }

        return back()->with('message',['text' =>  'Answer status updated successfully!', 'class' => 'success']);
    }
}
