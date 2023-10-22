<?php

namespace App\Livewire\User\Answer;

use App\Models\Question;
use App\Models\Topic;
use App\Models\TopicFollow;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class AnswerIndex extends Component
{
    use WithPagination;

    public int $limitPerPage = 5;

    public int $total_questions = 0;

    public bool $disabled = false;

    public $followed_topics = null;

    #[On('follow-topic')]
    public function mount()
    {
        $this->total_questions = Question::where('user_id', '!=', auth()->id())->count();
        $this->followed_topics = auth()->user()->topicFollowing()->get() ?? null;
    }

    public function loadMore()
    {
        try {

            if ($this->total_questions >= $this->limitPerPage) {
                $this->limitPerPage += 5;
            }

        } catch (\Throwable $th) {
            $this->dispatch('toastify',
                text: 'Get more questions failed, please try again later ',
                background: '#CB4B10',
            );
        }
    }

    public function render()
    {
        $id_topics = [];
        $topicFollow = TopicFollow::select('topic_id')->where('user_id', auth()->id())->get();

        foreach ($topicFollow as $topic) {
            $id_topics[] = $topic->topic_id;
        }

        $name_topics = [];
        $topics = Topic::select('name')->findMany($id_topics);

        foreach ($topics as $topic) {
            $name_topics[] = $topic->name;
        }

        $questions_id = [];
        foreach ($name_topics as $name_topic) {
            $questions = Question::search($name_topic)->get();
            if($questions->isNotEmpty()){
                foreach ($questions as $question) {
                    !in_array($question->id, $questions_id) ? $questions_id[] = $question->id : '';
                }
            }
        }

        if(count($questions_id) > 0){
            $questions = Question::whereIn('id', $questions_id)->where('user_id', '!=', auth()->id())->whereNull('status')->latest()->paginate($this->limitPerPage);
        }else{
            $questions = Question::where('user_id', '!=', auth()->id())->whereNull('status')->latest()->paginate($this->limitPerPage);
        }

        return view('livewire.user.answer.answer-index', compact('questions'));
    }
}
