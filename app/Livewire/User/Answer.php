<?php

namespace App\Livewire\User;

use App\Models\Comment;
use App\Models\Follow;
use App\Models\AnswerVote;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use App\Models\Answer as ModelAnswer;

class Answer extends Component
{
    public $answer;
    public $vote;
    public int $total_upvotes = 0;
    // public int $total_downvotes = 0;
    public int $total_comments = 0;
    public $credential = null;
    public bool $followed;
    public string $from = '';

    #[Rule('required|string')]
    public string $answer_edit;

    #[On('answer-updated')]
    #[On('update-comment')]
    public function mount()
    {
        $this->answer->load(['user','question','userAnswerVotes','comments']);
        $this->vote = $this->answer->userAnswerVotes->vote ?? null;
        $this->total_upvotes = $this->answer->total_upvotes;
        // $this->total_downvotes = $this->answer->total_downvotes;
        $this->total_comments = $this->answer->comments->count();
        $this->answer_edit = $this->answer->answer;
        $this->followed = auth()->user()->userIsFollowing($this->answer->user_id);
        $this->answer->user->credential == null ? $this->employmentCredential() : $this->credential = $this->answer->user->credential;
    }

    public function employmentCredential()
    {
        if($this->answer->user->employment()->exists())
        {
            $this->credential = $this->answer->user->employment->position . ' at ' . $this->answer->user->employment->company;
        }
    }

    public function votes(string $vote)
    {
        if($vote == 'up' || $vote == 'down')
        {
            try {

                if($this->vote == null)
                {
                    AnswerVote::create([
                        'answer_id' => $this->answer->id,
                        'user_id' => auth()->id(),
                        'vote' => $vote
                    ]);

                    $vote == 'up' ? $this->answer->increment('total_upvotes') : $this->answer->increment('total_downvotes');
                }
                else if($vote == $this->vote)
                {
                    $this->answer->userAnswerVotes->delete();

                    $vote == 'up' ? $this->answer->decrement('total_upvotes') : $this->answer->decrement('total_downvotes');
                }
                else
                {
                    $this->answer->userAnswerVotes->update(['vote' => $vote]);

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
                $this->dispatch('toastify',
                    text: 'Vote answer failed, please try again later ',
                    background: '#CB4B10',
                );
            }
        }
    }

    public function follow()
    {
        try {

            if($this->answer->user_id != auth()->id())
            {
                auth()->user()->userFollow($this->answer->user_id);
                $this->followed = true;

                $this->render();
            }

        } catch (\Throwable $th) {
            $this->dispatch('toastify',
                text: 'Follow user failed, please try again later ',
                background: '#CB4B10',
            );
        }
    }

    public function unfollow()
    {
        try {

            if($this->answer->user_id != auth()->id())
            {
                auth()->user()->userUnfollow($this->answer->user_id);
                $this->followed = false;

                $this->render();
            }

        } catch (\Throwable $th) {
            $this->dispatch('toastify',
                text: 'Unfollow user failed, please try again later ',
                background: '#CB4B10',
            );
        }
    }

    public function report(string $type)
    {
        try {
            //code...
        } catch (\Throwable $th) {
            $this->dispatch('toastify',
                text: 'Report answer failed, please try again later ',
                background: '#CB4B10',
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

                $this->dispatch('toastify',
                    text: 'Answer edited ',
                    background: '#2D9655',
                );

                $this->redirect(route('question.index', $this->answer->question->title_slug));
            }

            $this->redirect(route('question.index', $this->answer->question->title_slug));

        } catch (\Throwable $th) {
            $this->dispatch('toastify',
                text: 'Edit answer failed, please try again later ',
                background: '#CB4B10',
            );
        }
    }

    public function delete(ModelAnswer $answer)
    {
        $answer->load('question');
        $question_title_slug = $answer->question->title_slug;

        if(auth()->id() != $answer->user_id)
        {
            $this->redirect(route('question.index', $question_title_slug));
        }

        try {

            $answer->question->touch();
            $answer->delete();

            $this->dispatch('toastify',
                text: 'Delete answer success ',
                background: '#2D9655',
            );

            $this->redirect(route('question.index', $question_title_slug));

        } catch (\Throwable $th) {
            $this->dispatch('toastify',
                text: 'Delete answer failed, please try again later ',
                background: '#CB4B10',
            );
        }
    }

    public function render()
    {
        $this->answer->increment('total_views');
        return view('livewire.user.answer');
    }
}
