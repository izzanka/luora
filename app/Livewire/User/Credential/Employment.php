<?php

namespace App\Livewire\User\Credential;

use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Employment extends Component
{
    #[Rule(['required','string','max:40'])]
    public $position;

    #[Rule(['required','string','max:40'])]
    public $company;

    #[Rule(['required','string','min:4','max:4'])]
    public $start_year;

    #[Rule(['nullable','string','min:4','max:4'])]
    public $end_year;

    #[Rule(['required','boolean'])]
    public bool $currently;

    public function mount()
    {
        $this->position = auth()->user()->employment->position ?? null;
        $this->company = auth()->user()->employment->company ?? null;
        $this->start_year = auth()->user()->employment->start_year ?? null;
        $this->end_year = auth()->user()->employment->end_year ?? null;
        $this->currently = auth()->user()->employment->currently ?? false;
    }

    public function addEmploymentCredential()
    {
        $this->validate();

        try {

            $this->currently ? $end_year = null : $end_year = $this->end_year;

            auth()->user()->employment()->updateOrCreate([
            ],[
                'position' => $this->position,
                'company' => $this->company,
                'start_year' => $this->start_year,
                'end_year' => $end_year,
                'currently' => $this->currently,
            ]);

            $this->dispatch('swal',
                title: 'Update employment credential success',
                icon: 'success',
            );

            $this->redirect(route('profile.index', auth()->user()->username_slug));

        } catch (\Throwable $th) {
            $this->dispatch('swal',
                title: 'Update employment credential error',
                icon: 'error',
            );
        }
    }

    public function confirmDelete()
    {
        $this->dispatch('swal-dialog',
            title: 'Delete employment credential?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            cancelButtonColor: '#DB5E5F',
            confirmButtonColor: '#206BC4',
            name: 'employment',
        );
    }

    #[On('swal-employment-delete')]
    public function delete()
    {
        try {

            auth()->user()->employment->delete();

            $this->dispatch('swal',
                title: 'Delete employment credential success',
                icon: 'success',
            );

            $this->redirect(route('profile.index', auth()->user()->username_slug));

        } catch (\Throwable $th) {
            $this->dispatch('swal',
                title: 'Delete employment credential error',
                icon: 'error',
            );
        }
    }

    public function render()
    {
        return view('livewire.user.credential.employment');
    }
}
