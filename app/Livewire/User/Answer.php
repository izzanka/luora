<?php

namespace App\Livewire\User;

use App\Models\Vote;
use Livewire\Attributes\On;
use Livewire\Component;

class Answer extends Component
{
    public $answer;
    public $vote;
    public int $total_upvotes = 0;
    public int $total_downvotes = 0;

    #[On('voted')]
    public function mount()
    {
        $this->answer->load(['user','question','votes','userVotes']);
        $this->vote = $this->answer->userVotes->vote ?? null;
        $this->total_upvotes = $this->answer->votes->where('vote', 'up')->count();
        $this->total_downvotes = $this->answer->votes->where('vote', 'down')->count();
    }

    public function votes(string $vote)
    {
        try {

            if($this->vote == null)
            {
                Vote::create([
                    'answer_id' => $this->answer->id,
                    'user_id' => auth()->id(),
                    'vote' => $vote
                ]);
            }

            if($vote == $this->vote)
            {
                $this->answer->userVotes->delete();
            }

            $this->answer->userVotes->update(['vote' => $vote]);

            $this->dispatch('voted');

        } catch (\Throwable $th) {
            $this->dispatch('swal',
                title: 'Vote answer error',
                icon: 'error',
            );
        }
    }

    public function render()
    {
        return view('livewire.user.answer');
    }
}
