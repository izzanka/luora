<?php

namespace App\Livewire\User\Question;

use App\Models\Question;
use Livewire\Component;

class Show extends Component
{
    public $question;

    public function mount(Question $question)
    {
        $this->question = $question;
    }

    public function render()
    {
        return view('livewire.user.question.show');
    }
}
