<?php

namespace App\Livewire\User\Comments;

use App\Models\Comment;
use Livewire\Attributes\Rule;
use Livewire\Component;

class CommentCreate extends Component
{
    public ?Comment $commentModel = null;

    public $answerId = null;

    public $parentId = null;

    public ?string $message = null;

    public bool $showProfile = true;

    public bool $isEditing = false;

    #[Rule('required|string')]
    public string $comment = '';

    public function mount($answerId, $commentModel, $parentId, $showProfile, $isEditing)
    {
        $this->answerId = $answerId;
        $this->parentId = $parentId;
        $this->commentModel = $commentModel;
        $this->comment = $this->commentModel?->comment ?? '';
        $this->showProfile = $showProfile;
        $this->isEditing = $isEditing;
    }

    public function resetForm()
    {
        $this->comment = '';
        $this->parentId = null;
        $this->commentModel = null;
        $this->dispatch('hide-comment-form');
    }

    public function createComment()
    {
        $this->validateOnly('comment');

        try {

            if ($this->commentModel && $this->commentModel->comment) {

                if (auth()->id() == $this->commentModel->user_id) {
                    $this->commentModel->comment = $this->comment;
                    $this->commentModel->save();

                    $this->dispatch('toastify',
                        text: 'Edit comment success ',
                        background: '#2D9655',
                    );

                    $this->dispatch('comment-update');
                    $this->dispatch('hide-comment-form');
                }

            } else {

                $comment = Comment::create([
                    'comment' => $this->comment,
                    'answer_id' => $this->answerId,
                    'user_id' => auth()->id(),
                    'parent_id' => $this->parentId,
                ]);

                $this->dispatch('toastify',
                    text: 'Add comment success ',
                    background: '#2D9655',
                );

                $this->dispatch('hide-comment-form');
                $this->dispatch('comment-created', id: $comment->id);
            }

            $this->comment = '';

        } catch (\Throwable $th) {
            $this->dispatch('toastify',
                text: 'Edit comment failed, please try again later ',
                background: '#CB4B10',
            );
        }
    }

    public function render()
    {
        return view('livewire.user.comment.comment-create');
    }
}
