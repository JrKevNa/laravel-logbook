<?php

namespace App\Livewire;

use App\Models\Logbook;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Carbon\Carbon;
use Livewire\Component;

class AddLogbookModal extends Component
{
    public $formTitle = '';
    public $mode = '';

    public $logId;

    #[Validate('required')]
    public $logDate;

    #[Validate('required|numeric|min:0.1')]
    public $durationNumber;

    #[Validate('required|in:minutes,hours,days')]
    public $durationUnit;

    #[Validate('required|string|max:500')]
    public $activity;


    #[On('add-logbook')]
    public function add() {
        $this->resetValidation();
        $this->formTitle='Add Logbook';
        $this->mode = 'add';

        $this->logDate = Carbon::today()->format('Y-m-d');
        $this->durationNumber = '';
        $this->durationUnit = 'minutes';
        $this->activity = '';
    }

    #[On('edit-logbook')]
    public function edit($id) {
        $this->resetValidation();
        $this->formTitle='Edit Logbook';
        $this->mode = 'edit';

        $logbook = Logbook::findOrFail($id);

        $this->logId          = $logbook->id;
        $this->logDate        = $logbook->log_date;
        $this->activity       = $logbook->activity;
        $this->durationNumber = $logbook->duration_number;
        $this->durationUnit   = $logbook->duration_unit;
    }

    public function submit() {
        // MUST: user must be logged in
        if (!auth()->check()) {
            abort(403, 'You must be logged in.');
        }

        // MUST: user must have permission
        if (!auth()->user()->hasRole(['user'])) {
            abort(403, 'Unauthorized.');
        }

        $validated=$this->validate();

        if ($this->mode == 'add') {
            try {
                Logbook::create([
                    'log_date'        => $this->logDate,
                    'activity'        => $this->activity,
                    'duration_number' => $this->durationNumber,
                    'duration_unit'   => $this->durationUnit,
                    'company_id'      => Auth::user()->company_id,
                    'created_by'      => Auth::id(),
                ]);
    
                $this->dispatch('refresh-logbook');
    
                $this->dispatch('swal:modal', [
                    'type' => 'success',
                    'title' => 'Logbook created',
                    'text' => '',
                ]);
            } catch (\Throwable $e) { 
                $this->dispatch('swal:modal', [
                    'type' => 'error',
                    'title' => 'Error',
                    'text' => $e->getMessage(),
                ]);
            };
        } else if ( $this->mode == 'edit' ) {
            try {
                $log = Logbook::where('id', $this->logId)
                    ->where('company_id', Auth::user()->company_id)
                    ->firstOrFail();

                if ($log->company_id !== auth()->user()->company_id) {
                    abort(403, 'Unauthorized access');
                }

                if ($log->created_by !== auth()->user()->id) {
                    abort(403, 'Unauthorized access');
                }

                $log->update([
                    'log_date'        => $this->logDate,
                    'activity'        => $this->activity,
                    'duration_number' => $this->durationNumber,
                    'duration_unit'   => $this->durationUnit,
                    // you usually don't change created_by on edit
                ]);

                $this->dispatch('refresh-logbook');

                $this->dispatch('swal:modal', [
                    'type' => 'success',
                    'title' => 'Logbook updated',
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
    
    // public function render()
    // {
    //     return view('livewire.add-logbook-modal');
    // }
}
