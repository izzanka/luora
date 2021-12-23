<?php

namespace App\Http\Controllers\User;

use App\Models\Topic;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TopicController extends Controller
{
    public function store(Request $request){

        $request->validate([
            'name' => 'required|alpha|unique:topics,name|max:20|min:5'
        ]);

        $name = ucfirst($request->name);

        Topic::create([
            'name' => $name,
            'name_slug' => Str::of($name)->slug('-'),
        ]);

        return back()->with('message',['text' => 'Topic added successfully, our admin will check it soon!', 'class' => 'success']);
    }

    public function show(Topic $topic){
        $answers = [];
        $topic_id = $topic->id;
        $questions = Question::whereHas('topics',function($query)use($topic_id){$query->where('topic_id',$topic_id);})->get();
        $topics = Topic::orderBy('follower','desc')->take(8)->get();
        
        foreach($questions as $question){
            $answers = Answer::with(['user','question'])->where('question_id',$question->id)->latest()->get();
        }
  
        return view('user.topic.show',compact('topic','questions','answers','topics'));
    }
}
