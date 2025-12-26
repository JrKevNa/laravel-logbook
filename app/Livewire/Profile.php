<?php

namespace App\Livewire;

use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Profile extends Component
{
    public $roles = [];
    public $selectedRole;

    public $id;
    public $name;
    public $nik;
    public $email;

    public function mount() {
        $user = Auth::user();

        $this->id = $user->id;
        $this->name = $user->name;
        $this->nik = $user->nik;
        $this->email = $user->email;
        $this->selectedRole = $user->roles->first()?->id;

        $this->roles = Role::all();
    }

    public function submit() {
        // MUST: user must be logged in
        if (!auth()->check()) {
            abort(403, 'You must be logged in.');
        }

        // MUST: user must have permission
        if (!auth()->user()->hasRole('user')) {
            abort(403, 'Unauthorized.');
        }

        try {
            $user = User::findOrFail($this->id);

            if ($user->id !== auth()->user()->id) {
                abort(403, 'Unauthorized access');
            }

            $user->update([
                'name'  => $this->name,
                'nik'   => $this->nik,
                'email' => $this->email,
            ]);

            // update password only if needed
            // if ($this->wantToResetPassword) {
            //     $user->update([
            //         'password' => bcrypt($this->password)
            //     ]);
            // }

            $this->dispatch('swal:modal', [
                'type' => 'success',
                'title' => 'Profile updated',
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
        return view('livewire.profile');
    }
}
