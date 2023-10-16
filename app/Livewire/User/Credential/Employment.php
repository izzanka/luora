<?php

namespace App\Livewire\User\Credential;

use Livewire\Attributes\Rule;
use Livewire\Component;

class Employment extends Component
{
    #[Rule('required|string|max:40')]
    public string $position = '';

    #[Rule('required|string|max:40')]
    public string $company = '';

    #[Rule('required|string|min:4|max:4')]
    public string $start_year = '';

    #[Rule('nullable|string|min:4|max:4')]
    public string $end_year = '';

    #[Rule('required|boolean')]
    public bool $currently;

    public function mount()
    {
        $this->position = auth()->user()->employment->position ?? '';
        $this->company = auth()->user()->employment->company ?? '';
        $this->start_year = auth()->user()->employment->start_year ?? '';
        $this->end_year = auth()->user()->employment->end_year ?? '';
        $this->currently = auth()->user()->employment->currently ?? false;
    }

    public function addEmploymentCredential()
    {
        $this->validate();

        try {

            $this->currently ? $end_year = null : $end_year = $this->end_year;

            auth()->user()->employment()->updateOrCreate([
            ], [
                'position' => $this->position,
                'company' => $this->company,
                'start_year' => $this->start_year,
                'end_year' => $end_year,
                'currently' => $this->currently,
            ]);

            $this->dispatch('toastify',
                text: 'Update employment credential success ',
                background: '#2D9655',
            );

            $this->redirect(route('profile.index', auth()->user()->username_slug));

        } catch (\Throwable $th) {
            $this->dispatch('toastify',
                text: 'Update employment credential failed, please try again later ',
                background: '#CB4B10',
            );
        }
    }

    public function delete()
    {
        try {

            auth()->user()->employment->delete();

            $this->dispatch('toastify',
                text: 'Delete employment credential success ',
                background: '#2D9655',
            );

            $this->redirect(route('profile.index', auth()->user()->username_slug));

        } catch (\Throwable $th) {
            $this->dispatch('toastify',
                text: 'Delete employment credential failed, please try again later ',
                background: '#CB4B10',
            );
        }
    }

    public function render()
    {
        return view('livewire.user.credential.employment');
    }
}
