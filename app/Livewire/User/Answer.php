<?php

namespace App\Livewire\User;

use App\Models\Follow;
use App\Models\Vote;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Answer extends Component
{
    public $answer;
    public $vote;
    public int $total_upvotes = 0;
    public int $total_downvotes = 0;
    public string $from;
    public string $route;
    #[Rule(['required','string'])]
    public string $answer_edit;
    public bool $followed;

    #[On('answer-updated')]
    public function mount()
    {
        $this->answer->load(['user','question','votes','userVotes']);
        $this->vote = $this->answer->userVotes->vote ?? null;
        $this->total_upvotes = $this->answer->total_upvotes;
        $this->total_downvotes = $this->answer->total_downvotes;
        $this->answer_edit = $this->answer->answer;
        $this->followed = auth()->user()->isFollowing($this->answer->user_id);
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

                $this->dispatch('answer-updated');

            } catch (\Throwable $th) {
                $this->dispatch('swal',
                    title: 'Vote answer error',
                    icon: 'error',
                );
            }
        }
    }

    public function follow()
    {
        try {

            if($this->answer->user_id != auth()->id())
            {
                auth()->user()->follow($this->answer->user_id);
                $this->followed = true;
    
                $this->render();    
            }
           
        } catch (\Throwable $th) {
            $this->dispatch('swal',
                title: 'Follow error',
                icon: 'error',
            );
        }
    }

    public function unfollow()
    {
        try {

            if($this->answer->user_id != auth()->id())
            {
                auth()->user()->unfollow($this->answer->user_id);
                $this->followed = false;
    
                $this->render();
            }

        } catch (\Throwable $th) {
            $this->dispatch('swal',
                title: 'Unfollow error',
                icon: 'error',
            );
        }
    }

    public function report(string $type)
    {
        try {
            //code...
        } catch (\Throwable $th) {
            $this->dispatch('swal',
                title: 'Report answer error',
                icon: 'error',
            );
        }
    }

    public function edit()
    {
        if(auth()->id() != $this->answer->user_id)
        {
            $this->redirect(route('question.index', $this->answer->question->title_slug));
        }

        $this->validate();

        try {

            if($this->answer_edit != $this->answer->answer)
            {
                $this->answer->update([
                    'answer' => $this->answer_edit
                ]);

                $this->answer->question->touch();

                $this->dispatch('swal',
                    title: 'Answer edited',
                    icon: 'success',
                );

                $this->redirect(route('question.index', $this->answer->question->title_slug));
            }

            $this->redirect(route('question.index', $this->answer->question->title_slug));

        } catch (\Throwable $th) {
            $this->dispatch('swal',
                title: 'Edit answer error',
                icon: 'error',
            );
        }
    }

    public function confirmDelete($answer_id)
    {
        $this->dispatch('swal-dialog',
            title: 'Delete answer?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            cancelButtonColor: '#DB5E5F',
            confirmButtonColor: '#206BC4',
            answer_id: $answer_id,
            name: 'answer',
        );
    }

    public function render()
    {
        return view('livewire.user.answer');
    }
}
