<?php

namespace App\Livewire\User\Credential;

use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Location extends Component
{
    #[Rule('required','string','max:40')]
    public $location;

    #[Rule('required','string','min:4','max:4')]
    public $start_year;

    #[Rule('nullable','string','min:4','max:4')]
    public $end_year;

    #[Rule('required','boolean')]
    public bool $currently;

    public function mount()
    {
        $this->location = auth()->user()->location->location ?? null;
        $this->start_year = auth()->user()->location->start_year ?? null;
        $this->end_year = auth()->user()->location->end_year ?? null;
        $this->currently = auth()->user()->location->currently ?? false;
    }

    public function update()
    {
        $this->validate();

        try {

            auth()->user()->location()->updateOrCreate([],
            [
                'location' => $this->location,
                'start_year' => $this->start_year,
                'end_year' => $this->end_year,
                'currently' => $this->currently,
            ]);

            $this->dispatch('swal',
                title: 'Update location credential success',
                icon: 'success',
            );

            $this->redirect(route('profile.index', auth()->user()->username_slug));

        } catch (\Throwable $th) {
            $this->dispatch('swal',
                title: 'Update location credential error',
                icon: 'error',
            );
        }
    }

    public function confirmDelete()
    {
        $this->dispatch('swal-dialog',
            title: 'Delete location credential?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            cancelButtonColor: '#DB5E5F',
            confirmButtonColor: '#206BC4',
            name: 'location',
        );
    }

    #[On('swal-location-delete')]
    public function delete()
    {
        try {

            auth()->user()->location->delete();

            $this->dispatch('swal',
                title: 'Delete location credential success',
                icon: 'success',
            );

            $this->redirect(route('profile.index', auth()->user()->username_slug));

        } catch (\Throwable $th) {
            $this->dispatch('swal',
                title: 'Delete location credential error',
                icon: 'error',
            );
        }
    }

    public function render()
    {
        return view('livewire.user.credential.location');
    }
}
