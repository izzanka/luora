<?php

namespace App\Livewire\User\Question;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Topic;
use App\Models\TopicFollow;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class QuestionIndex extends Component
{
    use WithPagination;

    public $question;

    public int $limitPerPage = 5;

    public int $total_answers = 0;

    #[Rule('required|string')]
    public string $answer = '';

    public int $already_answer;

    public string $sort_by = 'Recent';

    public function mount(Question $question)
    {
        $this->question = $question;
        $this->already_answer = Answer::where('user_id', auth()->id())->where('question_id', $question->id)->count();
        $this->total_answers = Answer::where('question_id', $question->id)->count();
    }

    public function answerQuestion()
    {
        $this->validate();

        try {

            if ($this->already_answer != 0) {
                $this->dispatch('toastify',
                    text: 'You already answered the question ',
                    background: '#CB4B10',
                );

                $this->reset('answer');

            } elseif ($this->question->user_id == auth()->id()) {
                $this->dispatch('toastify',
                    text: 'Can`t answer your own question ',
                    background: '#CB4B10',
                );

                $this->reset('answer');
            }

            auth()->user()->answers()->create([
                'question_id' => $this->question->id,
                'answer' => $this->answer,
            ]);

            $this->question->touch();

            $this->dispatch('toastify',
                text: 'Question answered ',
                background: '#2D9655',
            );

            $this->redirect(route('question.index', $this->question->title_slug));

        } catch (\Throwable $th) {
            $this->dispatch('toastify',
                text: 'Answer question failed, please try again later ',
                background: '#CB4B10',
            );
        }
    }

    public function delete(Question $question)
    {
        try {

            // $answers = Answer::select('id', 'question_id')->where('question_id', $question->id)->get();

            // foreach ($answers as $answer) {
            //     $answer->delete();
            // }

            $question->delete();

            $this->dispatch('toastify',
                text: 'Delete question success ',
                background: '#2D9655',
            );

            $this->redirect(route('home'));

        } catch (\Throwable $th) {
            $this->dispatch('toastify',
                text: 'Delete question failed, please try again later ',
                background: '#CB4B10',
            );
        }
    }

    public function loadMore()
    {
        try {

            if ($this->total_answers >= $this->limitPerPage) {
                $this->limitPerPage += 5;
            }

        } catch (\Throwable $th) {
            $this->dispatch('toastify',
                text: 'Get answers failed, please try again later ',
                background: '#CB4B10',
            );
        }
    }

    public function sort()
    {
        $this->sort_by == 'Recent' ? $this->sort_by = 'Upvote' : $this->sort_by = 'Recent';
        $this->render();
    }

    public function render()
    {
        if ($this->sort_by == 'Recent') {
            $answers = Answer::with(['question', 'user'])->where('question_id', $this->question->id)->latest()->paginate($this->limitPerPage);
        } elseif ($this->sort_by == 'Upvote') {
            $answers = Answer::with(['question', 'user'])->where('question_id', $this->question->id)->orderByDesc('total_upvotes')->paginate($this->limitPerPage);
        }

        $titles = explode('-', $this->question->title_slug);

        $questions_id = [];
        foreach($titles as $title){
            $questions = Question::search($title)->where('id', '!=', $this->question->id)->get();
            if($questions->isNotEmpty()){
                foreach ($questions as $question) {
                    !in_array($question->id, $questions_id) ? $questions_id[] = $question->id : '';
                }
            }
        }

        if(count($questions_id) > 0) {
            $questions = Question::whereIn('id', $questions_id)->where('user_id', '!=', auth()->id())->whereNull('status')->latest()->paginate($this->limitPerPage);
        }else{
            $questions = Question::where('user_id', '!=', auth()->id())->whereNull('status')->latest()->paginate($this->limitPerPage);
        }

        return view('livewire.user.question.question-index', compact('answers', 'questions'));
    }
}
