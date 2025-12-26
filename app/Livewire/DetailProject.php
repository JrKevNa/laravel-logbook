<?php

namespace App\Livewire;

use App\Models\DetailProject as DetailProjectModel;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Component;

class DetailProject extends Component
{
    public $project;

    use WithPagination;
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
