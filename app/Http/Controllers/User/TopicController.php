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
            'topic_name' => 'required|alpha|unique:topics,name|max:20|min:5'
        ]);

        $name = ucfirst($request->topic_name);

        Topic::create([
            'name' => $name,
            'name_slug' => Str::of($name)->slug('-')
        ]);

        return back()->with('message',['text' => 'Topic added successfully', 'class' => 'success']);
    }

    public function show(Topic $topic){
        $topic_id = $topic->id;
        $answers = Answer::whereHas('question',function($query)use($topic_id){
            $query->whereHas('topics',function($q)use($topic_id){
                $q->where('topic_id',$topic_id);
            });
        })->get();
        
        return view('user.topic.show',compact('answers','topic'));
    }
}
