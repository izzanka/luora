<?php

namespace App\Http\Controllers\User;

use App\Models\Topic;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\QuestionTopic;
use App\Http\Controllers\Controller;

class QuestionController extends Controller
{
    public function edit_title($request){
        //remove space
       $removeSpace = str_replace(' ','-',$request->title);
       //remove special char
       $removeChar = preg_replace('/[^A-Za-z0-9\-]/', '',$removeSpace);
       //add space
       $addSpace = str_replace('-',' ',$removeChar);
       //make uppper case to first string and add ? in last string
       return ucfirst($addSpace) . '?';
    }

    public function show(Question $question){

        $answers = Answer::where('question_id',$question->id)->with('user')->latest()->get();
        $topics = Topic::all();
        $credential = "";

        views($question)
        ->cooldown(86400)
        ->record();

        foreach($answers as $answer){
            views($answer)
            ->cooldown(86400)
            ->record();
        }

        $link = route('question.show',$question);
        $facebook = \Share::page($link)->facebook()->getRawLinks();
        $twitter = \Share::page($link)->twitter()->getRawLinks();

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

        return view('user.question.show',compact('question','answers','topics','facebook','twitter','credential'));
    }

    public function store(Request $request){

        $request->validate([
            'title' => 'required',
        ]);

        $user = auth()->user();
        $title = $this->edit_title($request);
  
        $question = $user->questions()->create([
            'title' => $title,
            'title_slug' => Str::of($title)->slug('-'),
        ]);

        if($request->topic_id){
            $check = 0;
            for ($i=0; $i < count($request->topic_id) ; $i++) {
                $check++;
                //check if added topics more than 8
                if($check > 8){
                    // return back()->with('message',['text' => 'Topics cant more than 8!', 'class' => 'danger']);
                    break;
                }
                QuestionTopic::create([
                    'question_id' => $question->id,
                    'topic_id' => $request->topic_id[$i]
                ]);
            }
            
        }

        return back()->with('message',['text' => 'Question added successfully!', 'class' => 'success']);
    }

    public function update(Question $question,Request $request){

        if($request->title){

            $request->validate([
                'title' => 'required',
                'link' => 'url'
            ]);
    
            $user = auth()->user();
    
            $title = $this->edit_title($request);
            $title_slug = Str::of($title)->slug('-');
        
            $question->update([
                'title' => $title,
                'title_slug' => $title_slug,
            ]);
        }

        if($request->topic_id){

            $qtopics = QuestionTopic::where('question_id',$question->id)->get();

            foreach($qtopics as $qtopic){
                $qtopic->delete();
            }

            for ($i=0; $i < count($request->topic_id) ; $i++) { 
                QuestionTopic::create([
                    'question_id' => $question->id,
                    'topic_id' => $request->topic_id[$i]
                ]);
            }

            $title_slug = Str::of($question->title)->slug('-');
        }

        return redirect()->route('question.show',$title_slug)->with('message',['text' => 'Question updated successfully!', 'class' => 'success']);
    }

    public function destroy(Question $question){

        $qtopics = QuestionTopic::where('question_id',$question->id)->get();

        foreach($qtopics as $qtopic){
            $qtopic->delete();
        }

        foreach($question->answers as $answer){
            $answer->delete();
        }

        $question->delete();

        return redirect()->route('content.index')->with('message',['text' => 'Question deleted successfully!', 'class' => 'success']);
    }
}
