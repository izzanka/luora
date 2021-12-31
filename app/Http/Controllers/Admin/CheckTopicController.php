<?php

namespace App\Http\Controllers\Admin;

use App\Models\Topic;
use App\Models\Question;
use App\Models\UserTopic;
use Illuminate\Http\Request;
use App\Models\QuestionTopic;
use App\Http\Controllers\Controller;

class CheckTopicController extends Controller
{
    public function index(){
        $topics = Topic::whereNull('status')->orWhere('status','updated_by_user')->latest()->get();
        return view('admin.topic.index',compact('topics'));
    }

    public function update_status(Topic $topic,$status){
    
        if($status == 'deleted_by_admin'){

            $questionTopics = QuestionTopic::where('topic_id',$topic->id)->get();
            $userTopics = UserTopic::where('topic_id',$topic->id)->get();

            foreach($questionTopics as $questionTopic){
                $questionTopic->delete();
            }

            foreach($userTopics as $userTopic){
                $userTopic->delete();
            }

            $topic->delete();

        }else{
            return back();
        }

        return back()->with('message',['text' =>  'Topic deleted successfully!', 'class' => 'success']);
    }
}
