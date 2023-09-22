<?php

namespace App\Livewire\User\Answer;

use App\Models\Question;
use Livewire\Component;
use Livewire\WithPagination;

class AnswerIndex extends Component
{
    use WithPagination;
    public int $limitPerPage = 5;
    public int $total_questions = 0;

    public bool $disabled = false;

    public function mount()
    {
        $this->total_questions = Question::where('user_id', '!=', auth()->id())->count();
    }

    public function loadMore()
    {
        try {

            if($this->total_questions >= $this->limitPerPage){
                $this->limitPerPage += 5;
            }

        } catch (\Throwable $th) {
            $this->dispatch('swal',
                title: 'Get questions error',
                icon: 'error',
            );
        }
    }

    public function render()
    {
        $questions = Question::with('answers')->where('user_id', '!=', auth()->id())->whereNull('status')->latest()->paginate($this->limitPerPage);
        return view('livewire.user.answer.answer-index', compact('questions'));
    }
}
