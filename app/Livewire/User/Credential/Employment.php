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

    #[Rule(['required','max:4'])]
    public $employment_start_year;

    #[Rule(['required','max:4'])]
    public $employment_end_year;

    #[Rule(['required','boolean'])]
    public bool $employment_currently;

    public function mount()
    {
        $this->position = auth()->user()->employment->position ?? null;
        $this->company = auth()->user()->employment->company ?? null;
        $this->employment_start_year = auth()->user()->employment->start_year ?? 2020;
        $this->employment_end_year = auth()->user()->employment->end_year ?? null;
        $this->employment_currently = auth()->user()->employment->currently ?? false;
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

    public function updateEmploymentCredential()
    {
        $this->validateOnly(['position','company','employment_start_year','employment_end_year','employment_currently']);

        try {

            if(!auth()->user()->employment()->exists())
            {
                auth()->user()->employment()->create([
                    'position' => $this->position,
                    'company' => $this->company,
                    'start_year' => $this->start_year,
                    'end_year' => $this->end_year,
                    'currently' => $this->currently,
                ]);

                $this->dispatch('swal',
                    title: 'Add employment credential success',
                    icon: 'success',
                );

                $this->redirect(route('profile.index'));
            }

            auth()->user()->employment->update([
                'position' => $this->position,
                'company' => $this->company,
                'start_year' => $this->start_year,
                'end_year' => $this->end_year,
                'currently' => $this->currently,
            ]);

            $this->dispatch('swal',
                title: 'Update employment credential success',
                icon: 'success',
            );

            $this->redirect(route('profile.index'));

        } catch (\Throwable $th) {
            $this->dispatch('swal',
                title: 'Add employment credential error',
                icon: 'error',
            );
        }
    }

    public function render()
    {
        return view('livewire.user.credential.employment');
    }
}
