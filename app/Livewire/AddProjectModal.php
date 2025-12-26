<?php

namespace App\Livewire;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class AddProjectModal extends Component
{
    public $formTitle = '';
    public $mode = '';

    public $projectId;

    public $users = [];
    public $name;
    public $workedBy;
    public $requestedBy;
    public $startDate;
    public $endDate;
    public $note;
    // #[Validate('required|numeric|min:0.1')]
    public $durationNumber;

    // #[Validate('required|in:minutes,hours,days')]
    public $durationUnit;

    public function mount() {
        $this->users = User::all();
    }

    #[On('add-project')]
    public function add() {
        $this->resetValidation();
        $this->formTitle='Add Project';
        $this->mode = 'add';

        $this->name = '';
        $this->workedBy = '';
        $this->requestedBy = '';
        $this->startDate = '';
        $this->endDate = '';
        $this->note = '';
        $this->durationNumber = '';
        $this->durationUnit = '';
    }

    #[On('edit-project')]
    public function edit($id) {
        $this->resetValidation();
        $this->formTitle='Edit Project';
        $this->mode = 'edit';

        $project = Project::findOrFail($id);

        $this->projectId = $project->id;
        $this->name = $project->name;
        $this->workedBy = $project->worker->id;
        $this->requestedBy = $project->requested_by;
        $this->startDate = $project->start_date;
        $this->endDate = $project->end_date;
        $this->note = $project->note;
        $this->durationNumber = '';
        $this->durationUnit = '';
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

        $rules = [
            'name' => 'required|string|max:100',
            'workedBy' => 'required',
            'requestedBy' => 'required|string|max:100',
            'startDate'   => 'required|date',
            'endDate'     => 'required|date|after_or_equal:startDate',
        ];

        if ($this->mode === 'finish') {
            $rules['durationNumber'] = 'required|numeric|min:0.1';
            $rules['durationUnit'] = 'required|in:minutes,hours,days';
        }
        
        $validated=$this->validate($rules);

        if ($this->mode == 'add') {
            try {
                Project::create([
                    'name'          => $this->name,
                    'worked_by'     => $this->workedBy,
                    'requested_by'  => $this->requestedBy,
                    'start_date'    => $this->startDate,
                    'end_date'      => $this->endDate,
                    'note'          => $this->note,
                    'company_id'    => Auth::user()->company_id,
                    'created_by'    => Auth::id(),
                ]);
    
                $this->dispatch('refresh-projects');
                $this->dispatch('update-project-count');
    
                $this->dispatch('swal:modal', [
                    'type' => 'success',
                    'title' => 'Project created',
                    'text' => '',
                ]);
            } catch (\Throwable $e) { 
                $this->dispatch('swal:modal', [
                    'type' => 'error',
                    'title' => 'Error',
                    'text' => $e->getMessage(),
                ]);
            };
        } else if ($this->mode == 'edit') {
            try {
                $project = Project::findOrFail($this->projectId);

                if ($project->company_id !== auth()->user()->company_id) {
                    abort(403, 'Unauthorized access');
                }

                $project->update([
                    'name'          => $this->name,
                    'worked_by'     => $this->workedBy,
                    'requested_by'  => $this->requestedBy,
                    'start_date'    => $this->startDate,
                    'end_date'      => $this->endDate,
                    'note'          => $this->note,
                    'updated_by'    => Auth::id(),
                ]);

                $this->dispatch('refresh-projects');
    
                $this->dispatch('swal:modal', [
                    'type' => 'success',
                    'title' => 'Project updated',
                    'text' => '',
                ]);
            } catch (\Throwable $e) { 
                $this->dispatch('swal:modal', [
                    'type' => 'error',
                    'title' => 'Error',
                    'text' => $e->getMessage(),
                ]);
            };
        } else if ($this->mode == 'finish') {
            try {
                $project = Project::findOrFail($this->projectId);

                if ($project->company_id !== auth()->user()->company_id) {
                    abort(403, 'Unauthorized access');
                }

                $project->update([
                    'is_done'       => true,
                    'updated_by'    => Auth::id(),
                ]);

                $this->dispatch('refresh-projects');
                $this->dispatch('update-project-count');
    
                $this->dispatch('swal:modal', [
                    'type' => 'success',
                    'title' => 'Project updated',
                    'text' => '',
                ]);
            } catch (\Throwable $e) { 
                $this->dispatch('swal:modal', [
                    'type' => 'error',
                    'title' => 'Error',
                    'text' => $e->getMessage(),
                ]);
            };
        }
    }

    public function render()
    {
        return view('livewire.add-project-modal');
    }
}
