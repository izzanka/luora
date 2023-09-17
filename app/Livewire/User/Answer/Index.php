<?php

namespace App\Livewire\User\Answer;

use App\Models\Question;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    private $limitPerPage = 5;

    #[On('load-more')]
    public function loadMore()
    {
        try {

            $total_questions = Question::where('user_id', '!=', auth()->id())->count();

            if($total_questions >= $this->limitPerPage)
            {
                $this->limitPerPage += 5;
            }

        } catch (\Throwable $th) {
            $this->dispatch('swal',
                title: 'Get questions error',
                icon: 'error',
            );
        }
    }

    public function answer()
    {

    }

    public function render()
    {
        $questions = Question::where('user_id', '!=', auth()->id())->whereNull('status')->latest()->paginate($this->limitPerPage);
        return view('livewire.user.answer.index', compact('questions'));
    }
}
