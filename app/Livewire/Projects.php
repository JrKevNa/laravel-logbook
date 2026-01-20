<?php

namespace App\Livewire;

use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Component;

class Projects extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $searchTerm = '';

    public $showModal = false;

    #[On('refresh-projects')]
    public function refreshProjects() {
        $this->resetPage();
    }

    public function finish($id)
    {
        // MUST: user must be logged in
        // if (!auth()->check()) {
        //     abort(403, 'You must be logged in.');
        // }

        // // MUST: user must have permission
        // if (!auth()->user()->hasRole('user')) {
        //     abort(403, 'Unauthorized.');
        // }

        try {
            // Find project that belongs to the same company
            $project = Project::where('id', $id)
                ->where('company_id', auth()->user()->company_id)
                ->firstOrFail(); // aborts if not found
                
            $this->authorize('finish', $project);

            $project->update([
                'is_done'       => true,
                'updated_by'    => Auth::id(),
            ]);

            $this->dispatch('swal:modal', [
                'type' => 'success',
                'title' => 'Finsihed!',
                'text' => 'Project is finished.'
            ]);

            $this->refreshProjects();
            $this->dispatch('update-project-count');

        } catch (\Throwable $e) { 
            $this->dispatch('swal:modal', [
                'type' => 'error',
                'title' => 'Error',
                'text' => $e->getMessage(),
            ]);
        };
    }

    public function delete($id)
    {
        // MUST: user must be logged in
        // if (!auth()->check()) {
        //     abort(403, 'You must be logged in.');
        // }

        // // MUST: user must have permission
        // if (!auth()->user()->hasRole('user')) {
        //     abort(403, 'Unauthorized.');
        // }

        try {
            // Find project that belongs to the same company
            $project = Project::where('id', $id)
                ->where('company_id', auth()->user()->company_id)
                ->firstOrFail(); // aborts if not found

            $this->authorize('delete', $project);

            $project->delete();

            $this->dispatch('swal:modal', [
                'type' => 'success',
                'title' => 'Deleted!',
                'text' => 'Project has been deleted.'
            ]);

            // $this->refreshToDoList();
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
        $userId = Auth::id();

        $projects = Project::withCount([
                'details as remaining_details_count' => function ($q) {
                    $q->where('is_done', false);
                }
            ])
            ->whereHas('workers', function ($q) use ($userId) {
                $q->where('users.id', $userId); // only projects where this user is a worker
            })
            ->where('company_id', Auth::user()->company_id) // optional, if you also want company filtering
            ->where('name', 'like', '%' . $this->searchTerm . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.projects', compact('projects'));
    }

}
