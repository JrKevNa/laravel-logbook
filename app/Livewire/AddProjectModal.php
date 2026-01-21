<?php

namespace App\Livewire;

use App\Models\Project;
use App\Models\DetailProject;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AddProjectModal extends Component
{
    use AuthorizesRequests;

    public $formTitle = '';
    public $mode = '';

    public $projectId;

    public $users = [];
    public $name;
    public $workedBy = [];   // array of selected user IDs
    public $selections = []; // dynamic rows
    public $requestedBy;
    public $startDate;
    public $endDate;
    public $note;
    // #[Validate('required|numeric|min:0.1')]
    public $durationNumber;

    // #[Validate('required|in:minutes,hours,days')]
    public $durationUnit;

    public function mount()
    {
        $this->users = User::where('company_id', auth()->user()->company_id)->get();
    }


    #[On('add-project')]
    public function add() {
        $this->resetValidation();
        $this->formTitle='Add Project';
        $this->mode = 'add';

        $this->name = '';
        // $this->workedBy = '';
        $this->selections = [null];
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
        $this->authorize('update', $project);

        $this->projectId = $project->id;
        $this->name = $project->name;
        // Pre-fill selections with existing worker IDs
        $workerIds = $project->workers->pluck('id')->toArray();

        // If there are no workers, start with one empty selection
        $this->selections = !empty($workerIds) ? $workerIds : [null];
        $this->requestedBy = $project->requested_by;
        $this->startDate = $project->start_date;
        $this->endDate = $project->end_date;
        $this->note = $project->note;
        $this->durationNumber = '';
        $this->durationUnit = '';
    }

    // Add a new selection row
    public function addSelection()
    {
        $this->selections[] = null;
    }

    // Remove a selection row
    public function removeSelection($index)
    {
        unset($this->selections[$index]);
        $this->selections = array_values($this->selections); // reindex
    }

    public function submit() {
        // // MUST: user must be logged in
        // if (!auth()->check()) {
        //     abort(403, 'You must be logged in.');
        // }

        // // MUST: user must have permission
        // if (!auth()->user()->hasRole('user')) {
        //     abort(403, 'Unauthorized.');
        // }

        $this->workedBy = array_unique(array_filter($this->selections));

        $rules = [
            'name' => 'required|string|max:100',
            'workedBy' => 'required|array|min:1',      // must select at least 1 user
            'workedBy.*' => 'exists:users,id',        // each user must exist
            'requestedBy' => 'required|string|max:100',
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
        ];

        if ($this->mode === 'finish') {
            $rules['durationNumber'] = 'required|numeric|min:0.1';
            $rules['durationUnit'] = 'required|in:minutes,hours,days';
        }
        
        $validated=$this->validate($rules);

        if ($this->mode == 'add') {
            try {
                $this->authorize('create', Project::class);

                $project = Project::create([
                    'name'         => $this->name,
                    'requested_by' => $this->requestedBy,
                    'start_date'   => $this->startDate,
                    'end_date'     => $this->endDate,
                    'note'         => $this->note,
                    'company_id'   => Auth::user()->company_id,
                    'created_by'   => Auth::id(),
                ]);

                // Filter users by tenant/company
                $allowedUserIds = User::whereIn('id', $this->workedBy)
                    ->where('company_id', $project->company_id)
                    ->pluck('id')
                    ->toArray();

                // Prepare pivot data
                $syncData = [];
                foreach ($allowedUserIds as $userId) {
                    $syncData[$userId] = ['company_id' => $project->company_id];
                }

                // Sync pivot table safely
                $project->workers()->sync($syncData);

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
            }
        } elseif ($this->mode == 'edit') {
            try {
                $project = Project::findOrFail($this->projectId);
                $this->authorize('update', $project);

                $project->update([
                    'name'         => $this->name,
                    'requested_by' => $this->requestedBy,
                    'start_date'   => $this->startDate,
                    'end_date'     => $this->endDate,
                    'note'         => $this->note,
                    'updated_by'   => Auth::id(),
                ]);

                // Filter users by tenant/company
                $allowedUserIds = User::whereIn('id', $this->workedBy)
                    ->where('company_id', $project->company_id)
                    ->pluck('id')
                    ->toArray();

                // Existing workers
                $currentWorkerIds = $project->workers()
                    ->pluck('users.id')
                    ->toArray();

                // Workers being removed
                $removedUserIds = array_diff($currentWorkerIds, $allowedUserIds);

                // Block removal if they have contributed
                $blockingUserIds = DetailProject::where('project_id', $project->id)
                    ->whereIn('worked_by', $removedUserIds)
                    ->distinct()
                    ->pluck('worked_by')
                    ->toArray();

                // dd($blockingUserIds);

                if (! empty($blockingUserIds)) {
                    $blockingNames = User::whereIn('id', $blockingUserIds)
                        ->pluck('name')
                        ->implode(', ');

                    $this->dispatch('swal:modal_static', [
                        'type' => 'error',
                        'title' => 'Project update failed',
                        'text' => 'Cannot remove the following workers because they have contributed to this project: '. $blockingNames,
                    ]);

                    return;
                }

                // Prepare pivot data
                $syncData = [];
                foreach ($allowedUserIds as $userId) {
                    $syncData[$userId] = ['company_id' => $project->company_id];
                }

                // Sync pivot table safely
                $project->workers()->sync($syncData);

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
            }
        }

    }

    public function render()
    {
        return view('livewire.add-project-modal');
    }
}
