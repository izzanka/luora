<?php

namespace App\Livewire\User\Question;

use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Answer;
use App\Models\Question;
use Livewire\Attributes\Rule;
use Livewire\WithPagination;

class QuestionIndex extends Component
{
    use WithPagination;
    public $question;
    public int $limitPerPage = 5;
    public int $total_answers = 0;

    #[Rule(['required','string'])]
    public string $answer = '';
    public int $already_answer;
    public string $sort_by = '';

    public function mount(Question $question)
    {
        $this->question = $question;
        $this->already_answer = Answer::where('user_id', auth()->id())->where('question_id', $question->id)->count();
        $this->total_answers = Answer::where('question_id', $question->id)->count();
        $this->sort_by = 'Recent';
    }

    public function answerQuestion()
    {
        $this->validate();

        try {

            if($this->already_answer != 0)
            {
                $this->dispatch('swal',
                    title: 'You already answered the question',
                    icon: 'warning',
                );

                $this->reset('answer');

            }else if($this->question->user_id == auth()->id())
            {
                $this->dispatch('swal',
                    title: 'Can`t answer your own question',
                    icon: 'warning',
                );

                $this->reset('answer');
            }

            auth()->user()->answers()->create([
                'question_id' => $this->question->id,
                'answer' => $this->answer,
            ]);

            $this->question->touch();

            $this->dispatch('swal',
                title: 'Question answered',
                icon: 'success',
            );

            $this->redirect(route('question.index', $this->question->title_slug));

        } catch (\Throwable $th) {
            $this->dispatch('swal',
                title: 'Answer question error',
                icon: 'error',
            );
        }
    }

    public function loadMore()
    {
        try {

            if($this->total_answers >= $this->limitPerPage){
                $this->limitPerPage += 5;
            }

        } catch (\Throwable $th) {
            $this->dispatch('swal',
                title: 'Get answers error',
                icon: 'error',
            );
        }
    }

    public function sort()
    {
        $this->sort_by == 'Recent' ? $this->sort_by = 'Upvote' : $this->sort_by = 'Recent';
        $this->render();
    }

    #[On('swal-answer-delete')]
    public function delete(Answer $answer)
    {
        $answer->load('question');
        $question_title_slug = $answer->question->title_slug;

        if(auth()->id() != $answer->user_id)
        {
            $this->redirect(route('question.index', $question_title_slug));
        }

        try {

            $answer->question->touch();
            $answer->delete();

            $this->dispatch('swal',
                title: 'Delete answer success',
                icon: 'success',
            );

            $this->redirect(route('question.index', $question_title_slug));

        } catch (\Throwable $th) {
            $this->dispatch('swal',
                title: 'Delete answer error',
                icon: 'error',
            );
        }
    }

    public function render()
    {
        if($this->sort_by == 'Recent'){
            $answers = Answer::with(['question','user'])->where('question_id', $this->question->id)->latest()->paginate($this->limitPerPage);
        }else if($this->sort_by == 'Upvote'){
            $answers = Answer::with(['question','user'])->where('question_id', $this->question->id)->orderByDesc('total_upvotes')->paginate($this->limitPerPage);
        }
        $questions = Question::where('user_id', '!=', auth()->id())->where('id', '!=', $this->question->id)->latest()->take(5)->get();
        return view('livewire.user.question.question-index', compact('answers','questions'));
    }
}
