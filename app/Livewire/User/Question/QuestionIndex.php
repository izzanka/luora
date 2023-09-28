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
    public int $disabled;

    #[On('answer-deleted')]
    #[On('answered')]
    public function mount(Question $question)
    {
        $this->question = $question;
        $this->disabled = Answer::where('user_id', auth()->id())->where('question_id', $question->id)->count();
        $this->total_answers = Answer::where('question_id', $question->id)->count();
    }

    public function answerQuestion()
    {
        $this->validate();

        try {

            if($this->disabled > 1)
            {
                $this->dispatch('swal',
                    title: 'You already answered the question',
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
                title: 'You answer the question',
                icon: 'success',
            );
            $this->dispatch('answered');
            // $this->redirect(route('question.index', $this->question->title_slug));

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

    #[On('swal-answer-delete')]
    public function delete(Answer $answer)
    {
        $answer->load('question');

        if(auth()->id() != $answer->user_id)
        {
            $this->redirect(route('question.index', $answer->question->title_slug));
        }

        try {

            $answer->question->touch();
            $answer->delete();

            $this->dispatch('swal',
                title: 'Delete answer success',
                icon: 'success',
            );

            $this->dispatch('answer-deleted');

        } catch (\Throwable $th) {
            $this->dispatch('swal',
                title: 'Delete answer error',
                icon: 'error',
            );
        }
    }

    #[On('answer-deleted')]
    #[On('answered')]
    public function render()
    {
        $answers = Answer::with(['question','user'])->where('question_id', $this->question->id)->latest()->paginate($this->limitPerPage);
        $questions = Question::where('user_id', '!=', auth()->id())->where('id', '!=', $this->question->id)->latest()->take(5)->get();
        return view('livewire.user.question.question-index', compact('answers','questions'));
    }
}
