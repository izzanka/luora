<?php

namespace App\Livewire\User\Question;

use App\Models\Answer;
use Livewire\Attributes\Rule;
use Livewire\Component;

class QuestionShow extends Component
{
    public $question;

    #[Rule('required|string')]
    public string $answer = '';

    public int $already_answer;

    public function mount()
    {
        $this->already_answer = Answer::where('user_id', auth()->id())->where('question_id', $this->question->id)->count();
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

    public function render()
    {
        return view('livewire.user.question.question-show');
    }
}
