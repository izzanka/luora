<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

class Login extends Component
{
    #[Rule(['required', 'email', 'max:255'])]
    public $email = '';

    #[Rule(['required', 'max:255', 'min:8'])]
    public $password = '';

    #[Rule(['boolean'])]
    public $remember = false;

    public function login()
    {
        $this->validate();

        try {

            if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
                $this->redirect(route('home'));
            } else {
                $this->dispatch('swal',
                    title: 'Email or password is wrong',
                    icon: 'error',
                );
            }

        } catch (\Throwable $th) {
            $this->dispatch('swal',
                title: 'Login error',
                icon: 'error',
            );
        }
    }

    #[Title('Sign in | Luora')]
    public function render()
    {
        return view('livewire.auth.login');
    }
}
