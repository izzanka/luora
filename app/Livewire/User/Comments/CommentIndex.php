<?php

namespace App\Livewire\User\Comments;

use App\Models\Comment;
use Livewire\Attributes\On;
use Livewire\Component;

class CommentIndex extends Component
{
    public $answer;

    public $comments;

    public function mount()
    {
        $this->comments = Comment::with(['user', 'replies'])->where('answer_id', $this->answer->id)->whereNull('parent_id')->latest()->get();
    }

    #[On('comment-created')]
    public function commenCreated(int $id)
    {
        try {

            $comment = Comment::find($id);

            if (! $comment->parent_id) {
                $this->comments = $this->comments->prepend($comment);
            }

            $this->dispatch('update-comment');
            $this->mount();

        } catch (\Throwable $th) {
            $this->dispatch('toastify',
                text: 'Create comment failed, please try again later ',
                background: '#CB4B10',
            );
        }
    }

    public function render()
    {
        return view('livewire.user.comment.comment-index');
    }
}
