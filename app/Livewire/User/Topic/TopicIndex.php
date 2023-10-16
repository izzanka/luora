<?php

namespace App\Livewire\User\Topic;

use App\Models\Topic;
use Livewire\Attributes\On;
use Livewire\Component;

class TopicIndex extends Component
{
    public $followed_topics = null;

    public $search = '';

    #[On('follow-topic')]
    public function mount()
    {
        $this->followed_topics = auth()->user()->topicFollowing()->latest()->get() ?? null;
    }

    public function follow($topic_id)
    {
        try {

            if (! auth()->user()->topicIsFollowing($topic_id)) {

                auth()->user()->topicFollow($topic_id);

                $topic = Topic::find($topic_id);

                if ($topic) {
                    $topic->increment('total_followers');
                }

                $this->dispatch('toastify',
                    text: 'Follow topic success ',
                    background: '#2D9655',
                );

                $this->dispatch('follow-topic');

            } else {
                $this->dispatch('toastify',
                    text: 'Topic already followed ',
                    background: '#CB4B10',
                );
            }

        } catch (\Throwable $th) {
            $this->dispatch('toastify',
                text: 'Follow topic failed, please try again later ',
                background: '#CB4B10',
            );
        }
    }

    public function unfollow($topic_id)
    {
        try {

            auth()->user()->topicUnfollow($topic_id);

            $topic = Topic::find($topic_id);

            if ($topic) {
                $topic->decrement('total_followers');
            }

            $this->dispatch('toastify',
                text: 'Unfollow topic success ',
                background: '#2D9655',
            );

            $this->dispatch('follow-topic');

        } catch (\Throwable $th) {
            $this->dispatch('toastify',
                text: 'Unfollow topic failed, please try again later ',
                background: '#CB4B10',
            );
        }
    }

    public function render()
    {
        $topics = Topic::where('name', 'like', '%'.$this->search.'%')->latest()->get();

        return view('livewire.user.topic.topic-index', compact('topics'));
    }
}
