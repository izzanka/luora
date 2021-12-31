<?php

namespace App\Http\Controllers\User;

use App\Models\Topic;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Support\Str;
use App\Models\ReportAnswer;
use Illuminate\Http\Request;
use App\Models\QuestionTopic;
use App\Models\ReportComment;
use App\Models\ReportQuestion;
use App\Http\Controllers\Controller;

class QuestionController extends Controller
{
    //function edit title 
    public function edit_title($title){
       //remove space
       $removeSpace = str_replace(' ','-',$title);
       //remove special char
       $removeChar = preg_replace('/[^A-Za-z0-9\-]/', '',$removeSpace);
       //add space
       $addSpace = str_replace('-',' ',$removeChar);
       //make uppper case first letter title and add ? in last title
       return ucfirst($addSpace) . '?';
    }

    public function show(Question $question){

        $reported_question = false;

        $user_id = auth()->id();
        $answers = Answer::with('user')->where('question_id',$question->id)->latest()->paginate(4);
        $answered = Answer::where('question_id',$question->id)->where('user_id',$user_id)->first();
        $report_question = ReportQuestion::where('question_id',$question->id)->where('user_id',$user_id)->first();
        $topics = Topic::select(['id','name'])->get();
        
        $related_questions = null;

        if($question->topics){
            foreach($question->topics as $topic){
                $topic_id = $topic->id;
                $related_questions = Question::select(['title','title_slug'])->where('id','!=',$question->id)->whereHas('topics', function($query)use($topic_id){
                    $query->where('topic_id',$topic_id);
                })->latest()->paginate(8);
            }
        }

        $report_question_types = [
            [
                'name' => 'Harrasment',
                'desc' => 'Disparaging or adversarial towards a person or group'
            ],  
            [
                'name' => 'Spam',
                'desc' => 'Undisclosed promotion for a link or product'
            ],
            [
                'name' => 'Insincere',
                'desc' => 'Not seeking genuine answers'
            ],
            [
                'name' => 'Poorly written',
                'desc' => 'Not in English or has very bad formatting, grammar, and spelling'
            ],
            [
                'name' => 'Incorrect topics',
                'desc' => 'Topics are irrelevant to the content or overly broad'
            ]
        ];

        $report_answer_types = [
            [
                'name' => 'Harrasment',
                'desc' => 'Disparaging or adversarial towards a person or group'
            ],
            [
                'name' => 'Spam',
                'desc' => 'Undisclosed promotion for a link or product'
            ],
            [
                'name' => 'Doesnt answer the question',
                'desc' => 'Does not address question that was asked'
            ],
            [
                'name' => 'Plagiarism',
                'desc' => 'Reusing content without attribution'
            ],
            [
                'name' => 'Joke answer',
                'desc' => 'Not a sincere answer'
            ],
            [
                'name' => 'Poorly written',
                'desc' => 'Not in English or has very bad formatting, grammar, and spelling'
            ],
            [
                'name' => 'Inappropriate credential',
                'desc' => 'Authors credential is offensive, spam, or impersonation'
            ],
            [
                'name' => 'Factually incorrect',
                'desc' => 'Substantially incorrect and/or incorrect primary conclusions'
            ],
            [
                'name' => 'Adult content',
                'desc' => 'Sexually explicit, pornographic or otherwise inappropriate'
            ]
        ];

        $report_comment_types = [
            [
                'name' => 'Harrasment',
                'desc' => 'Disparaging or adversarial towards a person or group'
            ],  
            [
                'name' => 'Spam',
                'desc' => 'Undisclosed promotion for a link or product'
            ]
        ];
        
        if($report_question){
            $reported_question = true;
        }

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

        return view('user.question.show',compact('question','answers','answered','topics','facebook','twitter','reported_question','report_question_types','report_comment_types','report_answer_types','related_questions'));
    }

    public function store(Request $request){
     
        $request->replace(['title' => $request->title . '?','topic_id' => $request->topic_id]);
        $user = auth()->user();

        $request->validate([
            'title' => 'required|min:10|unique:questions,title',
        ]);

        $title = $this->edit_title($request->title);
  
        $question = $user->questions()->create([
            'title' => $title,
            'title_slug' => Str::of($title)->slug('-'),
        ]);

        $title_slug = Str::of($title)->slug('-');

        if($request->topic_id){

            $count = 0;
            for ($i=0; $i < count($request->topic_id) ; $i++) {
                $checkTopic = Topic::find($request->topic_id[$i]);
                $count++;
                //if added topics more than 8 or topic not found
                if($count > 8 || $checkTopic == null){
                    break;
                }
                QuestionTopic::create([
                    'question_id' => $question->id,
                    'topic_id' => $request->topic_id[$i]
                ]);
            }

        }

        return redirect()->route('question.show',$title_slug)->with('message',['text' => 'Question added successfully!', 'class' => 'success']);
    }

    public function update(Question $question,Request $request){

        if($request->title){

            $request->validate([
                'title' => 'required',
                'link' => 'url'
            ]);
    
            $user = auth()->user();
    
            $title = $this->edit_title($request->title);
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

    public function report(Request $request,Question $question){

        $user_id = auth()->id();
        $report = ReportQuestion::where('user_id',$user_id)->where('question_id',$question->id)->first();

        if($question->user_id == $user_id){
            return back();
        }

        if($report){
            return back()->with('message',['text' => 'Question already reported!', 'class' => 'danger']);
        }else{
            ReportQuestion::create([
                'user_id' => $user_id,
                'question_id' => $question->id,
                'type' => $request->type,
            ]);

            return back()->with('message',['text' => 'Question reported successfully!', 'class' => 'success']);
        }
    }

    public function destroy(Question $question){

        $qtopics = QuestionTopic::where('question_id',$question->id)->get();
        $reports = ReportQuestion::where('question_id',$question->id)->get();

        foreach($reports as $report){
            $report->delete();
        }

        foreach($qtopics as $qtopic){
            $qtopic->delete();
        }

        foreach($question->answers as $answer){
            foreach($answer->comments as $comment){
                $comment->delete();
            }
            $answer->delete();
        }

        $question->delete();

        return redirect()->route('content.index')->with('message',['text' => 'Question deleted successfully!', 'class' => 'success']);
    }
}
