<?php

namespace App\Livewire;

use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class AddUserModal extends Component
{
    public $formTitle = '';
    public $mode = '';

    public $userId;
    public $name;
    public $nik;
    public $email;
    public $selectedRole;
    public $roles = [];
    // public $wantToResetPassword = false;
    // public $password;
    // public $password_confirmation;

    public function mount() {
        $this->roles = Role::all();
    }

    #[On('add-user')]
    public function add() {
        $this->resetValidation();
        $this->formTitle='Add User';
        $this->mode = 'add';

        $this->name = '';
        $this->nik = '';
        $this->email = '';
        // $this->password = '';
        // $this->password_confirmation = '';
    }

    #[On('edit-user')]
    public function edit($id) {
        $this->resetValidation();
        $this->formTitle='Edit User';
        $this->mode = 'edit';

        $user = User::findOrFail($id);

        $this->userId = $user->id;
        $this->name = $user->name;
        $this->nik = $user->nik;
        $this->email = $user->email;
        $this->selectedRole = $user->roles->first()?->id;
        // $this->password = '';
        // $this->password_confirmation = '';
    }


    public function submit() {
        $this->authorize('manageUsers', User::class);
        
        $rules = [
            'name'  => 'required|string|max:100',
            'nik'  => 'required|string|max:100',
            'email' => 'required|email',
            'selectedRole' => 'required',
        ];

        $validated=$this->validate($rules);

        if ($this->mode == 'add') {
            $user = User::create([
                'name'       => $this->name,
                'nik'        => $this->nik,
                'email'      => $this->email,
                // 'password'   => Hash::make($this->password),
                'company_id' => Auth::user()->company_id,
            ]);

            UserRole::create([
                'user_id' => $user->id,
                'role_id' => $this->selectedRole, // Hardcoded admin
            ]);

            $this->dispatch('refresh-users');
            $this->dispatch('swal:modal', [
                'type' => 'success',
                'title' => 'User Added Succesfully',
                'text' => 'The user now can login!',
            ]);
        } else if ($this->mode == 'edit') {
            $user = User::findOrFail($this->userId);

            $user->update([
                'name'  => $this->name,
                'nik'   => $this->nik,
                'email' => $this->email,
            ]);

            // update role
            $user->roles()->sync([$this->selectedRole]);

            // update password only if needed
            // if ($this->wantToResetPassword) {
            //     $user->update([
            //         'password' => bcrypt($this->password)
            //     ]);
            // }

            $this->dispatch('refresh-users');
            $this->dispatch('swal:modal', [
                'type' => 'success',
                'title' => 'User updated',
            ]);
        }

        return;
    }

    public function render()
    {
        return view('livewire.add-user-modal');
    }
}
