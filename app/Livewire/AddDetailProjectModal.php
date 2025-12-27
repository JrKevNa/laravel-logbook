<?php

namespace App\Livewire;

use App\Models\Project;
use App\Models\DetailProject;
use App\Models\Logbook;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AddDetailProjectModal extends Component
{
    use AuthorizesRequests;

    public $formTitle = '';
    public $mode = '';
    public $users = [];

    public $selectedProjectId = '';

    public $detailProjectId;
    public $activity;
    public $requestDate;
    public $workedBy;
    public $requestedBy;
    public $note;
    public $isDone = false;
    // public $durationNumber;
    // public $durationUnit;

    public function mount() {
        $this->users = User::all();
    }

    #[On('add-detail-project')]
    public function add($id) {
        $this->resetValidation();
        $this->formTitle='Add Detail Project';
        $this->mode = 'add';

        $this->selectedProjectId = $id;

        $this->activity = '';
        $this->requestDate = '';
        $this->workedBy = '';
        $this->requestedBy = '';
        $this->note = '';
    }

    #[On('edit-detail-project')]
    public function edit($projectId, $detailId)
    {
        $this->resetValidation();
        $this->formTitle='Edit Detail Project';
        $this->mode = 'edit';

        $this->selectedProjectId = $projectId;

        $detailProject = DetailProject::findOrFail($detailId);
        $this->authorize('update', $detailProject);

        $this->detailProjectId = $detailProject->id;
        $this->activity = $detailProject->activity;
        $this->requestDate = $detailProject->request_date;
        $this->workedBy = $detailProject->worked_by;
        $this->requestedBy = $detailProject->requested_by;
        $this->note = $detailProject->note;
        // $this->durationNumber = '';
        // $this->durationUnit = '';
    }

    #[On('finish-detail-project')]
    public function finish($projectId, $detailId)
    {
        $this->resetValidation();
        $this->formTitle='Finish Detail Project';
        $this->mode = 'finish';

        $this->selectedProjectId = $projectId;

        $detailProject = DetailProject::findOrFail($detailId);
        $this->authorize('finish', $detailProject);

        
        $this->detailProjectId = $detailProject->id;
        $this->activity = $detailProject->activity;
        $this->requestDate = $detailProject->request_date;
        $this->workedBy = $detailProject->worked_by;
        $this->requestedBy = $detailProject->requested_by;
        $this->note = $detailProject->note;
        // $this->durationNumber = '';
        // $this->durationUnit = '';
    }


    public function submit() {
        // MUST: user must be logged in
        // if (!auth()->check()) {
        //     abort(403, 'You must be logged in.');
        // }

        // // MUST: user must have permission
        // if (!auth()->user()->hasRole('user')) {
        //     abort(403, 'Unauthorized.');
        // }
        
        $rules = [
            'activity'      => 'required|string|max:500',
            'workedBy'      => 'required',
            'requestedBy'   => 'required|string|max:100',
            'requestDate'   => 'required|date',
            'note'          => 'string|max:500',
        ];

        // if ($this->mode === 'finish') {
        //     $rules['durationNumber'] = 'required|numeric|min:0.1';
        //     $rules['durationUnit'] = 'required|in:minutes,hours,days';
        // }
        
        $validated=$this->validate($rules);

        if ($this->mode == 'add') {
            try {
                $this->authorize('create', DetailProject::class);

                DetailProject::create([
                    'project_id'    => $this->selectedProjectId,
                    'activity'      => $this->activity,
                    'worked_by'     => $this->workedBy,
                    'requested_by'  => $this->requestedBy,
                    'request_date'  => $this->requestDate,
                    'note'          => $this->note,
                    'company_id'    => Auth::user()->company_id,
                    'created_by'    => Auth::id(),
                ]);
    
                $this->dispatch('refresh-detail-projects');
    
                $this->dispatch('swal:modal', [
                    'type' => 'success',
                    'title' => 'Detail Project created',
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
                $detailProject = DetailProject::findOrFail($this->detailProjectId);

                // if ($detailProject->company_id !== auth()->user()->company_id) {
                //     abort(403, 'Unauthorized access');
                // }
                $this->authorize('update', $detailProject);

                $detailProject->update([
                    'activity'      => $this->activity,
                    'worked_by'     => $this->workedBy,
                    'requested_by'  => $this->requestedBy,
                    'request_date'  => $this->requestDate,
                    'note'          => $this->note,
                    'updated_by'    => Auth::id(),
                ]);

                $this->dispatch('refresh-detail-projects');
    
                $this->dispatch('swal:modal', [
                    'type' => 'success',
                    'title' => 'Detail Project updated',
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
                $detailProject = DetailProject::findOrFail($this->detailProjectId);

                // if ($detailProject->company_id !== auth()->user()->company_id) {
                //     abort(403, 'Unauthorized access');
                // }
                $this->authorize('finish', $detailProject);

                $detailProject->update([
                    'is_done'       => true,
                    'updated_by'    => Auth::id(),
                ]);

                // Logbook::create([
                //     'log_date'        => Carbon::today(),
                //     'activity'        => $detailProject->activity,
                //     'duration_number' => $this->durationNumber,
                //     'duration_unit'   => $this->durationUnit,
                //     'company_id'      => Auth::user()->company_id,
                //     'created_by'      => Auth::id(),
                // ]);

                $this->dispatch('refresh-detail-projects');
    
                $this->dispatch('swal:modal', [
                    'type' => 'success',
                    'title' => 'Detail Project updated',
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
        return view('livewire.add-detail-project-modal');
    }
}
