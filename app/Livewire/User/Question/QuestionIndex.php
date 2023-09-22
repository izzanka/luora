<?php

namespace App\Livewire\User\Question;

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
    public bool $disabled;

    public function mount(Question $question)
    {
        $this->question = $question;
        $check_if_already_answered = Answer::where('user_id', auth()->id())->where('question_id', $this->question->id)->count();
        $check_if_already_answered > 0 ? $this->disabled = true : $this->disabled = false;
        $this->total_answers = Answer::where('question_id', $question->id)->count();
    }

    public function answerQuestion()
    {
        $this->validate();

        try {

            if($this->disabled)
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

    public function render()
    {
        $answers = Answer::with(['question','user'])->where('question_id', $this->question->id)->latest()->paginate($this->limitPerPage);
        $questions = Question::where('user_id', '!=', auth()->id())->where('id', '!=', $this->question->id)->latest()->take(5)->get();
        return view('livewire.user.question.question-index', compact('answers','questions'));
    }
}
