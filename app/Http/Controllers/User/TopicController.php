<?php

namespace App\Http\Controllers\User;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TopicController extends Controller
{
    public function store(Request $request){

        $request->validate([
            'name' => 'required|alpha|unique:topics,name|max:20|min:5'
        ]);

        $name = ucfirst($request->name);

        Topic::create(['name' => $name]);

        return back()->with('message',['text' => 'Topic added successfully, our admin will check it soon!', 'class' => 'success']);
    }
}
