<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

class Login extends Component
{
    #[Rule('required|email|max:255')]
    public string $email = '';

    #[Rule('required|max:255|min:8')]
    public string $password = '';

    #[Rule('boolean')]
    public bool $remember = false;

    public function login()
    {
        $this->validate();

        try {

            if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
                $this->redirect(route('home'));
            } else {
                $this->dispatch('toastify',
                    text: 'Email or password is wrong ',
                    background: '#CB4B10',
                );
            }

        } catch (\Throwable $th) {
            $this->dispatch('toastify',
                text: 'Login failed, please try again later ',
                background: '#CB4B10',
            );
        }
    }

    #[Title('Sign in | Luora')]
    public function render()
    {
        return view('livewire.auth.login');
    }
}
