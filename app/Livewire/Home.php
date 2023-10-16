<?php

namespace App\Livewire;

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Home extends Component
{
    use WithPagination;

    private $limitPerPage = 5;

    #[Rule('required|string|min:10|max:200')]
    public string $title;

    #[Url]
    public $search = '';

    protected $queryString = [
        'search',
    ];

    #[On('increase-limit')]
    public function increaseLimitPerPage()
    {
        try {

            $total_answers = Answer::where('user_id', '!=', auth()->id())->count();

            if ($total_answers >= $this->limitPerPage) {
                $this->limitPerPage += 5;
            }

        } catch (\Throwable $th) {
            $this->dispatch('toastify',
                text: 'Get answers failed, please try again later ',
                background: '#CB4B10',
            );
        }
    }

    public function editQuestionTitle()
    {
        $removeSpace = str_replace(' ', '-', $this->title);
        $removeSpecialChar = preg_replace('/[^A-Za-z0-9\-]/', '', $removeSpace);
        $addSpace = str_replace('-', ' ', $removeSpecialChar);

        return ucfirst($addSpace).'?';
    }

    public function addQuestion()
    {
        $this->validateOnly('title');

        try {

            $title = $this->editQuestionTitle();
            $title_slug = str()->slug($this->title);

            $sameQuestion = Question::where('title_slug', $title_slug)->count();

            if ($sameQuestion != 0) {
                $this->dispatch('toastify',
                    text: 'Question already been asked ',
                    background: '#CB4B10',
                );

            } else {

                auth()->user()->questions()->create([
                    'title' => $title,
                    'title_slug' => $title_slug,
                ]);

                $this->dispatch('toastify',
                    text: 'Question asked ',
                    background: '#2D9655',
                );
            }

            $this->redirect(route('question.index', $title_slug));

        } catch (\Throwable $th) {
            $this->dispatch('toastify',
                text: 'Ask question failed, please try again later ',
                background: '#CB4B10',
            );
        }
    }

    public function render()
    {
        $answers = Answer::groupBy('user_id')->where('user_id', '!=', auth()->id())->whereNull('status')->latest()->distinct()->paginate($this->limitPerPage);
        $users = User::select('id', 'username', 'username_slug')->where('username', 'like', '%'.$this->search.'%')->latest()->get();

        return view('livewire.home', compact('answers', 'users'));
    }
}
