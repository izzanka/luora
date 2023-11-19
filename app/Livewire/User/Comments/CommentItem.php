<?php

namespace App\Livewire\User\Comments;

use App\Models\Comment;
use App\Models\CommentVote;
use Livewire\Attributes\On;
use Livewire\Component;

class CommentItem extends Component
{
    public $comment;

    public bool $replying = false;

    public bool $editing = false;

    // public $vote;

    // public int $total_upvotes = 0;

    public function mount(Comment $comment)
    {
        // $comment->load('userCommentVotes');
        $this->comment = $comment;
        // $this->vote = $this->comment->userCommentVotes->vote ?? null;
        // $this->total_upvotes = $this->comment->total_upvotes;
    }

    public function startReplying()
    {
        $this->replying = true;
        $this->editing = false;
    }

    public function startEditing()
    {
        $this->replying = false;
        $this->editing = true;
    }

    public function cancelReplying()
    {
        $this->replying = false;
    }

    public function cancelEditing()
    {
        $this->editing = false;
    }

    #[On('comment-updated')]
    private function commentUpdate()
    {
        $this->editing = false;
    }

    #[On('hide-comment-form')]
    public function hideCommentForm()
    {
        $this->cancelReplying();
        $this->cancelEditing();
    }

    public function deleteComment($from)
    {
        try {

            if (auth()->id() == $this->comment->user_id) {

                $comments = Comment::select('id', 'parent_id')->where('parent_id', $this->comment->id)->get();

                foreach ($comments as $comment) {
                    $comment->delete();
                }

                $this->comment->delete();

                $this->dispatch('toastify',
                    text: 'Delete comment success ',
                    background: '#2D9655',
                );

                if ($from == 'home') {
                    $this->redirect(route('home'));
                } else {
                    $this->redirect(route('question.index', $from));
                }
            }

        } catch (\Throwable $th) {
            $this->dispatch('toastify',
                text: 'Delete comment failed, please try again later ',
                background: '#CB4B10',
            );
        }
    }

    // public function votes(string $vote, string $from)
    // {
    //     if ($vote == 'up' || $vote == 'down') {
    //         try {

    //             if ($this->vote == null) {
    //                 CommentVote::create([
    //                     'comment_id' => $this->comment->id,
    //                     'user_id' => auth()->id(),
    //                     'vote' => $vote,
    //                 ]);

    //                 $vote == 'up' ? $this->comment->increment('total_upvotes') : $this->comment->increment('total_downvotes');
    //             } elseif ($vote == $this->vote) {
    //                 $this->comment->userCommentVotes->delete();

    //                 $vote == 'up' ? $this->comment->decrement('total_upvotes') : $this->comment->decrement('total_downvotes');
    //             } else {
    //                 $this->comment->userCommentVotes->update(['vote' => $vote]);

    //                 if ($vote == 'up') {
    //                     $this->comment->increment('total_upvotes');
    //                     $this->comment->decrement('total_downvotes');
    //                 } else {
    //                     $this->comment->increment('total_downvotes');
    //                     $this->comment->decrement('total_upvotes');
    //                 }
    //             }

    //             $this->dispatch('toastify',
    //                 text: 'Vote comment success ',
    //                 background: '#2D9655',
    //             );

    //             if ($from == 'home') {
    //                 $this->redirect(route('home'));
    //             } else {
    //                 $this->redirect(route('question.index', $from));
    //             }

    //         } catch (\Throwable $th) {
    //             $this->dispatch('toastify',
    //                 text: 'Vote comment failed, please try again later ',
    //                 background: '#CB4B10',
    //             );
    //         }
    //     }
    // }

    #[On('comment-created')]
    private function commentCreated(int $id)
    {
        $this->cancelReplying();
    }

    #[On('comment-created')]
    #[On('comment-votes')]
    public function render()
    {
        return view('livewire.user.comment.comment-item');
    }
}
