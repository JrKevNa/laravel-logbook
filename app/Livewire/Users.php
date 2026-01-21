<?php

namespace App\Livewire;

use App\Models\User as UserModel;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Component;

class Users extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $searchTerm = '';

    public $showModal = false;

    public function mount()
    {
        logger(static::class . ' mounted');
    }


    #[On('refresh-users')]
    public function refreshUsers() {
        $this->resetPage();
    }

    public function render()
    {
        $users = UserModel::where('company_id', Auth::user()->company_id)
            ->where(function($query) {
                $query->where('name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $this->searchTerm . '%');
            })
            ->orderBy('name', 'asc')
            ->paginate(10);

        return view('livewire.users', [
            'users' => $users,
        ]);
    }

}
