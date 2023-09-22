<?php

namespace App\Livewire\User\Question;

use App\Models\Answer;
use App\Models\Question;
use Livewire\Attributes\Rule;
use Livewire\Component;

class QuestionShow extends Component
{
    public $question;

    #[Rule(['required','string'])]
    public string $answer = '';
    public bool $disabled;

    public function mount()
    {
        $check_if_already_answered = Answer::where('user_id', auth()->id())->where('question_id', $this->question->id)->count();
        $check_if_already_answered > 0 ? $this->disabled = true : $this->disabled = false;
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

    public function render()
    {
        return view('livewire.user.question.question-show');
    }
}
