<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\ToDoList;
use App\Models\Project;
use Livewire\Attributes\On;

class Navbar extends Component
{
    public $todoCount = 0;
    public $projectCount = 0;

    public function mount()
    {
        $this->refreshToDoCount();
        $this->refreshProjectCount();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    #[On('update-to-do-count')]
    public function refreshToDoCount()
    {
        $this->todoCount = ToDoList::where('is_done', false)
            ->where('created_by', auth()->user()->id)
            ->count();
    }

    #[On('update-project-count')]
    public function refreshProjectCount()
    {
        $userId = auth()->id();

        $this->projectCount = Project::where('is_done', false)
            ->whereHas('workers', function ($q) use ($userId) {
                $q->where('users.id', $userId); // only projects where current user is a worker
            })
            ->where('company_id', auth()->user()->company_id) // optional if you still want to filter by company
            ->count();
    }


    public function render()
    {
        return view('livewire.navbar');
    }
}
