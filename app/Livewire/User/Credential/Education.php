<?php

namespace App\Livewire\User\Credential;

use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Education extends Component
{
    #[Rule('required','string','max:40')]
    public $school;

    #[Rule('required','string','max:40')]
    public $major;

    #[Rule('required','string','max:40')]
    public $degree_type;

    #[Rule(['nullable','string','min:4','max:4'])]
    public $graduation_year;

    public function mount()
    {
        $this->school = auth()->user()->education->school ?? null;
        $this->major = auth()->user()->education->major ?? null;
        $this->degree_type = auth()->user()->education->degree_type ?? null;
        $this->graduation_year = auth()->user()->education->graduation_year ?? null;
    }

    public function update()
    {
        $this->validate();

        try {

            auth()->user()->education()->updateOrCreate([
            ],[
                'school' => $this->school,
                'major' => $this->major,
                'degree_type' => $this->degree_type,
                'graduation_year' => $this->graduation_year,
            ]);

            $this->dispatch('swal',
                title: 'Update education credential success',
                icon: 'success',
            );

            $this->redirect(route('profile.index', auth()->user()->username_slug));

        } catch (\Throwable $th) {
            $this->dispatch('swal',
                title: 'Update education credential error',
                icon: 'error',
            );
        }
    }

    public function confirmDelete()
    {
        $this->dispatch('swal-dialog',
            title: 'Delete education credential?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            cancelButtonColor: '#DB5E5F',
            confirmButtonColor: '#206BC4',
            name: 'education',
        );
    }

    #[On('swal-education-delete')]
    public function delete()
    {
        try {

            auth()->user()->education->delete();

            $this->dispatch('swal',
                title: 'Delete education credential success',
                icon: 'success',
            );

            $this->redirect(route('profile.index', auth()->user()->username_slug));

        } catch (\Throwable $th) {
            $this->dispatch('swal',
                title: 'Delete education credential error',
                icon: 'error',
            );
        }
    }

    public function render()
    {
        return view('livewire.user.credential.education');
    }
}
