<?php

namespace App\Livewire\User\Credential;

use Livewire\Attributes\Rule;
use Livewire\Component;

class Location extends Component
{
    #[Rule('required|string|max:40')]
    public string $location = '';

    #[Rule('required|string|min:4|max:4')]
    public string $start_year = '';

    #[Rule('nullable|string|min:4|max:4')]
    public string $end_year = '';

    #[Rule('required|boolean')]
    public bool $currently;

    public function mount()
    {
        $this->location = auth()->user()->location->location ?? '';
        $this->start_year = auth()->user()->location->start_year ?? '';
        $this->end_year = auth()->user()->location->end_year ?? '';
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

            $this->dispatch('toastify',
                text: 'Update location credential success ',
                background: '#2D9655',
            );

            $this->redirect(route('profile.index', auth()->user()->username_slug));

        } catch (\Throwable $th) {
            $this->dispatch('toastify',
                text: 'Update location credential error ',
                background: '#CB4B10',
            );
        }
    }

    public function delete()
    {
        try {

            auth()->user()->location->delete();

            $this->dispatch('toastify',
                text: 'Delete location credential success ',
                background: '#2D9655',
            );

            $this->redirect(route('profile.index', auth()->user()->username_slug));

        } catch (\Throwable $th) {
            $this->dispatch('toastify',
                text: 'Delete location credential error ',
                background: '#CB4B10',
            );
        }
    }

    public function render()
    {
        return view('livewire.user.credential.location');
    }
}
