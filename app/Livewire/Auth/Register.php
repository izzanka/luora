<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

class Register extends Component
{
    #[Rule(['required', 'string', 'max:19', 'unique:users,username'])]
    public $username = '';

    #[Rule(['required', 'email', 'max:255', 'unique:users,email'])]
    public $email = '';

    #[Rule(['required', 'min:8', 'max:255'])]
    public $password = '';

    public function register()
    {
        $this->validate();

        try {

            DB::transaction(function () {
                $user = User::create([
                    'username' => $this->username,
                    'username_slug' => str()->slug($this->username),
                    'email' => $this->email,
                    'password' => bcrypt($this->password),
                ]);

                Auth::login($user);

                $this->redirect(route('home'));
            });

        } catch (\Throwable $th) {
            $this->dispatch('swal',
                title: 'Register error',
                icon: 'error',
            );
        }
    }

    #[Title('Sign up | LinkMe')]
    public function render()
    {
        return view('livewire.auth.register');
    }
}
