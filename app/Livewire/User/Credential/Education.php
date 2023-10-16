<?php

namespace App\Livewire\User\Credential;

use Livewire\Attributes\Rule;
use Livewire\Component;

class Education extends Component
{
    #[Rule('required|string|max:40')]
    public string $school = '';

    #[Rule('required|string|max:40')]
    public string $major = '';

    #[Rule('required|string|max:40')]
    public string $degree_type = '';

    #[Rule('nullable|string|min:4|max:4')]
    public string $graduation_year = '';

    public function mount()
    {
        $this->school = auth()->user()->education->school ?? '';
        $this->major = auth()->user()->education->major ?? '';
        $this->degree_type = auth()->user()->education->degree_type ?? '';
        $this->graduation_year = auth()->user()->education->graduation_year ?? '';
    }

    public function update()
    {
        $this->validate();

        try {

            auth()->user()->education()->updateOrCreate([
            ], [
                'school' => $this->school,
                'major' => $this->major,
                'degree_type' => $this->degree_type,
                'graduation_year' => $this->graduation_year,
            ]);

            $this->dispatch('toastify',
                text: 'Update education credential success ',
                background: '#2D9655',
            );

            $this->redirect(route('profile.index', auth()->user()->username_slug));

        } catch (\Throwable $th) {
            $this->dispatch('toastify',
                text: 'Update education credential failed, please try again later ',
                background: '#CB4B10',
            );
        }
    }

    public function delete()
    {
        try {

            auth()->user()->education->delete();

            $this->dispatch('toastify',
                text: 'Delete education credential success ',
                background: '#2D9655',
            );

            $this->redirect(route('profile.index', auth()->user()->username_slug));

        } catch (\Throwable $th) {
            $this->dispatch('toastify',
                text: 'Delete education credential failed, please try again later ',
                background: '#CB4B10',
            );
        }
    }

    public function render()
    {
        return view('livewire.user.credential.education');
    }
}
