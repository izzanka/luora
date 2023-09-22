<?php

namespace App\Livewire;

use App\Models\Answer;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Home extends Component
{
    use WithPagination;
    private $limitPerPage = 5;

    #[Rule(['required','string','min:10','unique:questions'])]
    public string $title;

    #[On('increase-limit')]
    public function increaseLimitPerPage()
    {
        try {

            $total_answers = Answer::where('user_id', '!=', auth()->id())->count();

            if($total_answers >= $this->limitPerPage)
            {
                $this->limitPerPage += 5;
            }

        } catch (\Throwable $th) {
            $this->dispatch('swal',
                title: 'Get answers error',
                icon: 'error',
            );
        }
    }

    public function editQuestionTitle()
    {
        $removeSpace = str_replace(' ', '-', $this->title);
        $removeSpecialChar = preg_replace('/[^A-Za-z0-9\-]/', '',$removeSpace);
        $addSpace = str_replace('-', ' ', $removeSpecialChar);
        return ucfirst($addSpace) . '?';
    }

    public function addQuestion()
    {
        $this->validate();

        try {

            $title = $this->editQuestionTitle();
            $title_slug = str()->slug($this->title);

            auth()->user()->questions()->create([
                'title' => $title,
                'title_slug' => $title_slug,
            ]);

            $this->redirect(route('question.index', $title_slug));

        } catch (\Throwable $th) {
            $this->dispatch('swal',
                title: 'Ask question error ' . $th->getMessage(),
                icon: 'error',
            );
        }
    }

    public function render()
    {
        $answers = Answer::where('user_id','!=',auth()->id())->whereNull('status')->latest()->paginate($this->limitPerPage);
        return view('livewire.home', compact('answers'));
    }
}
