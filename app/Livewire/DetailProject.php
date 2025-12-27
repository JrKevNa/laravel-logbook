<?php

namespace App\Livewire;

use App\Models\DetailProject as DetailProjectModel;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DetailProject extends Component
{
    public $project;

    use WithPagination;
    use AuthorizesRequests;

    protected $paginationTheme = 'bootstrap';

    public $searchTerm = '';

    public $showModal = false;

    public function mount($id)
    {
        $this->project = Project::findOrFail($id);
    }

    #[On('refresh-detail-projects')]
    public function refreshDetailProjects() {
        $this->resetPage();
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
            $detailProject = DetailProjectModel::where('id', $id)
                ->where('company_id', auth()->user()->company_id)
                ->firstOrFail(); // aborts if not found

            $this->authorize('delete', $detailProject);

            $detailProject->delete();

            $this->dispatch('swal:modal', [
                'type' => 'success',
                'title' => 'Deleted!',
                'text' => 'Detail Project has been deleted.'
            ]);

            $this->refreshDetailProjects();
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
        $detailProjects = DetailProjectModel::where('company_id', Auth::user()->company_id)
            ->where('activity', 'like', '%' . $this->searchTerm . '%')
            ->where('project_id', $this->project->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.detail-project', [
            'detailProjects' => $detailProjects
        ]);
    }
}
