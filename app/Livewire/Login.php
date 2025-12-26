<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;

    public function login()
    {
        try {
            $this->validate([
                'email' => 'required|email',
                'password' => 'required|min:5',
            ]);
    
            $credentials = [
                'email' => $this->email,
                'password' => $this->password,
            ];
    
            if (Auth::attempt($credentials, $this->remember)) {
                session()->regenerate();
                return redirect()->route('dashboard');
            } else {
                $this->dispatch('swal:modal', [
                    'type' => 'error',
                    'title' => 'Login Failed',
                    'text' => 'Invalid email or password.',
                ]);
            }
        } catch (\Throwable $e) { 
            $this->dispatch('swal:modal', [
                'type' => 'error',
                'title' => 'Error',
                'text' => $e->getMessage(),
            ]);
        };
    }

    public function render()
    {
        return view('livewire.login');
    }
}
