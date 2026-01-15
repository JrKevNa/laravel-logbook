<?php

namespace App\Livewire;

use App\Models\Logbook;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AddLogbookModal extends Component
{
    use AuthorizesRequests;

    public $inputMode = 'duration'; // default
    public $formTitle = '';
    public $mode = '';

    public $logId;

    #[Validate('required')]
    public $logDate;

    // #[Validate('required|numeric|min:0.1')]
    public $durationNumber;

    // #[Validate('required|in:minutes,hours,days')]
    public $durationUnit;

    #[Validate('required|string|max:500')]
    public $activity;

    public $startTime;

    public $endTime;

    protected function rules()
    {
        if ($this->inputMode === 'time') {
            return [
                'startTime' => 'required|date_format:H:i',
                'endTime'   => 'required|date_format:H:i|after:startTime',
            ];
        }

        return [
            'durationNumber' => 'required|numeric|min:0.1',
            'durationUnit'   => 'required|in:minutes,hours,days',
        ];
    }

    public function updatedInputMode()
    {
        if ($this->inputMode === 'time') {
            $this->durationNumber = null;
            $this->durationUnit   = 'minutes';
        } else {
            $this->durationNumber = null;
            $this->durationUnit   = 'minutes';

            $this->startTime = null;
            $this->endTime   = null;
        }

        $this->resetValidation();
    }


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
        $this->authorize('update', $logbook);

        $this->logId          = $logbook->id;
        $this->logDate        = $logbook->log_date;
        $this->activity       = $logbook->activity;

        // Decide input mode based on data
        if ($logbook->start_time && $logbook->end_time) {
            $this->inputMode = 'time';

            // dd($logbook->start_time);

            $this->startTime = Carbon::parse($logbook->start_time)->format('H:i');
            $this->endTime   = Carbon::parse($logbook->end_time)->format('H:i');

            // Optional: clear duration fields to avoid stale data
            $this->durationNumber = null;
            $this->durationUnit   = null;
        } else {
            $this->inputMode = 'duration';

            $this->durationNumber = $logbook->duration_number;
            $this->durationUnit   = $logbook->duration_unit;

            // Optional: clear time fields
            $this->startTime = null;
            $this->endTime   = null;
        }
    }

    public function submit() {
        // MUST: user must be logged in
        // if (!auth()->check()) {
        //     abort(403, 'You must be logged in.');
        // }

        // // MUST: user must have permission
        // if (!auth()->user()->hasRole(['user'])) {
        //     abort(403, 'Unauthorized.');
        // }

        $validated=$this->validate();

        // Normalize time input → duration (MANDATORY)
        if ($this->inputMode === 'time') {
            $start = \Carbon\Carbon::createFromFormat('H:i', $this->startTime);
            $end   = \Carbon\Carbon::createFromFormat('H:i', $this->endTime);

            $minutes = $end->diffInMinutes($start);

            if ($minutes <= 0) {
                throw new \LogicException('Duration must be greater than zero.');
            }

            $validated['duration_number'] = $minutes;
            $validated['duration_unit']   = 'minutes';

            // Optional: persist raw times for audit / display
            $validated['start_time'] = $this->startTime;
            $validated['end_time']   = $this->endTime;
        } else {
            // Duration mode: explicitly null time fields
            $validated['duration_number'] = $this->durationNumber;
            $validated['duration_unit']   = $this->durationUnit;

            $validated['start_time'] = null;
            $validated['end_time']   = null;
        }

        // GUARANTEE invariant
        if (
            empty($validated['duration_number']) ||
            empty($validated['duration_unit'])
        ) {
            throw new \LogicException('Invalid logbook state: duration missing.');
        }

        if ($this->mode == 'add') {
            try {
                $this->authorize('create', Logbook::class);

                Logbook::create([
                    'log_date'        => $this->logDate,
                    'activity'        => $this->activity,
                    // 'duration_number' => $this->durationNumber,
                    // 'duration_unit'   => $this->durationUnit,
                    'duration_number' => $validated['duration_number'],
                    'duration_unit'   => $validated['duration_unit'],
                    'start_time'      => $validated['start_time'],
                    'end_time'        => $validated['end_time'],
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

                // if ($log->company_id !== auth()->user()->company_id) {
                //     abort(403, 'Unauthorized access');
                // }

                // if ($log->created_by !== auth()->user()->id) {
                //     abort(403, 'Unauthorized access');
                // }
                $this->authorize('update', $log);

                $log->update([
                    'log_date'        => $this->logDate,
                    'activity'        => $this->activity,
                    // 'duration_number' => $this->durationNumber,
                    // 'duration_unit'   => $this->durationUnit,
                    'duration_number' => $validated['duration_number'],
                    'duration_unit'   => $validated['duration_unit'],
                    'start_time'      => $validated['start_time'],
                    'end_time'        => $validated['end_time'],
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
