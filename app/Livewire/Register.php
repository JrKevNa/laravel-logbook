<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\UserRole;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Register extends Component
{
    public $companyName;
    public $name;
    public $nik;
    public $email;
    // public $password;
    // public $password_confirmation;

    public function register()
    {
        try {
            // 1. Validate input
            $this->validate([
                'companyName' => 'required|string|max:255',
                'name'        => 'required|string|max:255',
                'nik'         => 'required|string|max:255',
                'email'       => 'required|email|unique:users,email',
                // 'password'    => 'required|confirmed|min:6',
            ]);

            // 2. Create company
            $company = Company::create([
                'name' => $this->companyName,
            ]);

            // 3. Create user
            $user = User::create([
                'name'       => $this->name,
                'nik'        => $this->nik,
                'email'      => $this->email,
                // 'password'   => Hash::make($this->password),
                'company_id' => $company->id,
            ]);

            // 4. Assign admin role (role_id = 1)
            UserRole::create([
                'user_id' => $user->id,
                'role_id' => 1, // Hardcoded admin
            ]);

            // Optional redirect
            $this->dispatch('swal:modal', [
                'type' => 'success',
                'title' => 'User Registered Succesfully',
                'text' => 'You can now proceed to login!',
            ]);
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
        return view('livewire.register');
    }
}
