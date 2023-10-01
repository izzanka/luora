<?php

namespace App\Livewire\User\Profile;

use App\Models\User;
use Livewire\Component;
use Illuminate\Validation\Rule;

class ProfileIndex extends Component
{
    // public $position;
    // public $company;
    // public $employment_start_year;
    // public $employment_end_year;
    // public bool $employment_currently;
    public $username;
    public $credential;
    public $description;
    public $image;
    public $answers = null;
    public $questions = null;
    public bool $show;

    public function rules()
    {
        return [
            'username' => ['required','string','max:25', Rule::unique('users')->ignore(auth()->id())],
            'credential' => ['string','max:60'],
            'description' => ['string','max:255'],
        ];
    }

    public function mount(User $user)
    {
        if($user->id != auth()->id()){
            $this->username = $user->username;
            $this->credential = $user->credential;
            $this->description = $user->description;
            $this->image = $user->image;
            $this->show = false;
        }else{
            $this->username = auth()->user()->username;
            $this->credential = auth()->user()->credential;
            $this->description = auth()->user()->description;
            $this->image = auth()->user()->image;
            $this->show = true;
        }
        // $this->position = auth()->user()->employment->position ?? null;
        // $this->company = auth()->user()->employment->company ?? null;
        // $this->employment_start_year = auth()->user()->employment->start_year ?? 2020;
        // $this->employment_end_year = auth()->user()->employment->end_year ?? null;
        // $this->employment_currently = auth()->user()->employment->currently ?? false;

    }

    // public function employmentCredential()
    // {
    //     $year_or_currently = $this->employment_currently ? 'present' : $this->employment_end_year;
    //     $year_or_null = $year_or_currently ? ' (' . $this->employment_start_year . ' - ' . $year_or_currently . ')' : ' (' . $this->employment_start_year . ')';

    //     return [
    //         'credential' => $this->position . ' at ' . $this->company,
    //         'year' => $year_or_null,
    //     ];
    // }

    // public function updateEmploymentCredential()
    // {
    //     $this->validateOnly(['position','company','employment_start_year','employment_end_year','employment_currently']);

    //     try {

    //         if(!auth()->user()->employment()->exists())
    //         {
    //             auth()->user()->employment->create([
    //                 'position' => $this->position,
    //                 'company' => $this->company,
    //                 'start_year' => $this->start_year,
    //                 'end_year' => $this->end_year,
    //                 'currently' => $this->currently,
    //             ]);

    //             $this->dispatch('swal',
    //                 title: 'Add employment credential success',
    //                 icon: 'success',
    //             );

    //         }else{

    //             auth()->user()->employment->update([
    //                 'position' => $this->position,
    //                 'company' => $this->company,
    //                 'start_year' => $this->start_year,
    //                 'end_year' => $this->end_year,
    //                 'currently' => $this->currently,
    //             ]);

    //             $this->dispatch('swal',
    //                 title: 'Update employment credential success',
    //                 icon: 'success',
    //             );
    //         }

    //         $this->redirect(route('profile.index'));

    //     } catch (\Throwable $th) {
    //         $this->dispatch('swal',
    //             title: 'Add employment credential error',
    //             icon: 'error',
    //         );
    //     }
    // }

    public function updateProfile()
    {
        $this->validate();

        try {

            $username_slug = str()->slug($this->username);

            auth()->user()->update([
                'username' => $this->username,
                'username_slug' => $username_slug,
                'credential' => $this->credential,
                'description' => $this->description
            ]);

            $this->dispatch('swal',
                title: 'Edit profile success',
                icon: 'success',
            );

            $this->redirect(route('profile.index', $username_slug));

        } catch (\Throwable $th) {
            $this->dispatch('swal',
                title: 'Edit profile error ' . $th->getMessage(),
                icon: 'error',
            );
        }
    }

    public function showAnswers()
    {
        $this->questions = null;
        $this->answers = auth()->user()->answers()->select(['id','user_id','question_id','answer','created_at'])->with('question:id,title,title_slug')->latest()->get();
        $this->render();
    }

    public function showQuestions()
    {
        $this->answers = null;
        $this->questions = auth()->user()->questions()->latest()->get();
        $this->render();
    }

    public function render()
    {
        return view('livewire.user.profile.profile-index');
    }
}
