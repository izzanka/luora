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
    public int $already_answer;

    public function mount()
    {
        $this->already_answer = Answer::where('user_id', auth()->id())->where('question_id', $this->question->id)->count();
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
            }
            else if($this->question->user_id == auth()->id())
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

    public function render()
    {
        return view('livewire.user.question.question-show');
    }
}
