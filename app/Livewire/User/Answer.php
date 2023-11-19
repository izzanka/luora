<?php

namespace App\Livewire\User;

use App\Models\Answer as ModelAnswer;
use App\Models\AnswerVote;
use App\Models\Share;
use App\Models\Vote;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Answer extends Component
{
    public $answer;

    public $vote;

    public int $total_upvotes = 0;
    public int $total_views = 0;
    public int $total_comments = 0;

    public int $total_shares = 0;

    public $credential = null;

    public bool $followed;

    public string $from = '';

    #[Rule('required|string')]
    public string $answer_edit;

    #[On('answer-updated')]
    #[On('update-comment')]
    public function mount()
    {
        $this->answer->load(['user', 'question', 'votes', 'comments', 'shares']);
        $this->vote = $this->answer->userVotes->vote ?? null;
        $this->total_upvotes = $this->answer->total_upvotes;
        $this->total_views = views($this->answer)->count();
        $this->total_comments = $this->answer->comments->count();
        $this->total_shares = $this->answer->total_shares;
        $this->answer_edit = $this->answer->answer;
        $this->followed = auth()->user()->userIsFollowing($this->answer->user_id);
        $this->answer->user->credential == null ? $this->employmentCredential() : $this->credential = $this->answer->user->credential;
    }

    public function employmentCredential()
    {
        if ($this->answer->user->employment()->exists()) {
            $this->credential = $this->answer->user->employment->position.' at '.$this->answer->user->employment->company;
        }
    }

    public function votes(string $vote)
    {
        if ($vote == 'up' || $vote == 'down') {

            try {

                if($this->answer->user_id != auth()->id())
                {
                    if ($this->vote == null) {
                        Vote::create([
                            'answer_id' => $this->answer->id,
                            'user_id' => auth()->id(),
                            'vote' => $vote,
                        ]);

                        $vote == 'up' ? $this->answer->increment('total_upvotes') : $this->answer->increment('total_downvotes');
                    } elseif ($vote == $this->vote) {
                        $this->answer->userVotes->delete();

                        $vote == 'up' ? $this->answer->decrement('total_upvotes') : $this->answer->decrement('total_downvotes');
                    } else {
                        $this->answer->userVotes->update(['vote' => $vote]);

                        if ($vote == 'up') {
                            $this->answer->increment('total_upvotes');
                            $this->answer->decrement('total_downvotes');
                        } else {
                            $this->answer->increment('total_downvotes');
                            $this->answer->decrement('total_upvotes');
                        }
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

            if ($this->answer->user_id != auth()->id()) {
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

            if ($this->answer->user_id != auth()->id()) {
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
        if (auth()->id() != $this->answer->user_id) {
            $this->redirect(route('question.index', $this->answer->question->title_slug));
        }

        $this->validate();

        try {

            if ($this->answer_edit != $this->answer->answer) {
                $this->answer->update([
                    'answer' => $this->answer_edit,
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

        if (auth()->id() != $answer->user_id) {
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

    public function share(string $name)
    {
        try {

            $share = Share::where('user_id', auth()->id())->where('answer_id', $this->answer->id)->where('name', $name)->get();

            if($share->isEmpty() || $this->answer->user_id != auth()->id())
            {
                $this->answer->increment('total_shares');

                Share::create([
                    'user_id' => auth()->id(),
                    'answer_id' => $this->answer->id,
                    'name' => $name,
                    'shared_at' => now(),
                ]);

                $this->dispatch('toastify',
                    text: 'Share answer success ',
                    background: '#2D9655',
                );
            }

            $this->mount();

        } catch (\Throwable $th) {
            $this->dispatch('toastify',
                text: 'Share answer failed, please try again later.' . $th->getMessage(),
                background: '#CB4B10',
            );
        }
    }

    public function render()
    {
        views($this->answer)->cooldown(60)->record();

        $uri = route('question.index', $this->answer->question->title_slug) . '#' . $this->answer->user->username_slug;

        $shares = [
            [
                'name' => 'Facebook',
                'url' => 'https://www.facebook.com/sharer/sharer.php?u=' . $uri,
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" class="me-2 icon icon-tabler icon-tabler-brand-meta" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 10.174c1.766 -2.784 3.315 -4.174 4.648 -4.174c2 0 3.263 2.213 4 5.217c.704 2.869 .5 6.783 -2 6.783c-1.114 0 -2.648 -1.565 -4.148 -3.652a27.627 27.627 0 0 1 -2.5 -4.174z"></path>
                            <path d="M12 10.174c-1.766 -2.784 -3.315 -4.174 -4.648 -4.174c-2 0 -3.263 2.213 -4 5.217c-.704 2.869 -.5 6.783 2 6.783c1.114 0 2.648 -1.565 4.148 -3.652c1 -1.391 1.833 -2.783 2.5 -4.174z"></path>
                          </svg>'
            ],
            [
                'name' => 'Twitter',
                'url' => 'https://twitter.com/intent/tweet/' . $uri,
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" class="me-2 icon icon-tabler icon-tabler-brand-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M4 4l11.733 16h4.267l-11.733 -16z"></path>
                            <path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772"></path>
                          </svg>'
            ]
        ];

        return view('livewire.user.answer', compact('shares'));
    }
}
