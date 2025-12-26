<?php

namespace App\Livewire;

use App\Models\ToDoList as ToDoListModel;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Component;

class ToDoList extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $searchTerm = '';

    public $showModal = false;
    
    #[On('refresh-to-do-list')]
    public function refreshToDoList() {
        $this->resetPage();
    }

    public function delete($id)
    {
        // MUST: user must be logged in
        if (!auth()->check()) {
            abort(403, 'You must be logged in.');
        }

        // MUST: user must have permission
        if (!auth()->user()->hasRole(['user'])) {
            abort(403, 'Unauthorized.');
        }

        try {
            $toDoList = ToDoListModel::where('id', $id)
                ->where('company_id', auth()->user()->company_id)
                ->where('created_by', auth()->user()->id)
                ->firstOrFail(); // aborts if not found

            $toDoList->delete();
            $this->dispatch('update-to-do-count');

            $this->dispatch('swal:modal', [
                'type' => 'success',
                'title' => 'Deleted!',
                'text' => 'To Do has been deleted.'
            ]);

            $this->refreshToDoList();
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
        $toDoList = ToDoListModel::with('creator')      // eager load user relationship
            ->where('company_id', Auth::user()->company_id)
            ->where('created_by', Auth::user()->id)
            ->where('activity', 'like', '%' . $this->searchTerm . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.to-do-list', [
            'toDoList' => $toDoList
        ]);
    }
}
