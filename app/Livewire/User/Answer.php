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
    public string $from;

    #[On('voted')]
    public function mount($from = '')
    {
        $this->answer->load(['user','question','votes','userVotes']);
        $this->from = $from;
        $this->vote = $this->answer->userVotes->vote ?? null;
        $this->total_upvotes = $this->answer->total_upvotes;
        $this->total_downvotes = $this->answer->total_downvotes;
        $this->answer->increment('total_views');
    }

    public function votes(string $vote)
    {
        if($vote == 'up' || $vote == 'down')
        {
            try {

                if($this->vote == null)
                {
                    Vote::create([
                        'answer_id' => $this->answer->id,
                        'user_id' => auth()->id(),
                        'vote' => $vote
                    ]);

                    $vote == 'up' ? $this->answer->increment('total_upvotes') : $this->answer->increment('total_downvotes');
                }
                else if($vote == $this->vote)
                {
                    $this->answer->userVotes->delete();

                    $vote == 'up' ? $this->answer->decrement('total_upvotes') : $this->answer->decrement('total_downvotes');
                }
                else
                {
                    $this->answer->userVotes->update(['vote' => $vote]);

                    if($vote == 'up'){
                        $this->answer->increment('total_upvotes');
                        $this->answer->decrement('total_downvotes');
                    }else{
                        $this->answer->increment('total_downvotes');
                        $this->answer->decrement('total_upvotes');
                    }
                }

                $this->dispatch('voted');

            } catch (\Throwable $th) {
                $this->dispatch('swal',
                    title: 'Vote answer error',
                    icon: 'error',
                );
            }
        }
    }

    public function render()
    {
        return view('livewire.user.answer');
    }
}
