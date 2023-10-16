<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

class Register extends Component
{
    #[Rule('required|string|max:19|unique:users,username')]
    public string $username = '';

    #[Rule('required|email|max:255|unique:users,email')]
    public string $email = '';

    #[Rule('required|min:8|max:255')]
    public string $password = '';

    public function register()
    {
        $this->validate();

        try {

            $user = User::create([
                'username' => $this->username,
                'username_slug' => str()->slug($this->username),
                'email' => $this->email,
                'password' => bcrypt($this->password),
            ]);

            Auth::login($user);

            $this->redirect(route('home'));

        } catch (\Throwable $th) {
            $this->dispatch('toastify',
                text: 'Register failed, please try again later ',
                backgorund: '#CB4B10',
            );
        }
    }

    #[Title('Sign up | Luora')]
    public function render()
    {
        return view('livewire.auth.register');
    }
}
