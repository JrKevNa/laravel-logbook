<?php

namespace App\Livewire;

use App\Models\ToDoList;
use App\Models\Logbook;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Carbon\Carbon;

class AddToDoModal extends Component
{
    public $formTitle = '';
    public $mode = '';

    public $toDoId;

    // #[Validate('required|numeric|min:0.1')]
    public $durationNumber;

    // #[Validate('required|in:minutes,hours,days')]
    public $durationUnit;

    // #[Validate('required|string|max:500')]
    public $activity;

    #[On('add-to-do')]
    public function add() {
        $this->resetValidation();
        $this->formTitle='Add To Do';
        $this->mode = 'add';

        $this->durationNumber = '';
        $this->durationUnit = '';
        $this->activity = '';
    }

    #[On('edit-to-do')]
    public function edit($id) {
        $this->resetValidation();
        $this->formTitle='Edit To Do';
        $this->mode = 'edit';

        $toDo = ToDoList::findOrFail($id);

        $this->toDoId         = $toDo->id;
        $this->activity       = $toDo->activity;
        $this->durationNumber = '';
        $this->durationUnit   = '';
    }

    #[On('finish-to-do')]
    public function finish($id) {
        $this->resetValidation();
        $this->formTitle='Finish To Do';
        $this->mode = 'finish';

        $toDo = ToDoList::findOrFail($id);

        $this->toDoId         = $toDo->id;
        $this->activity       = $toDo->activity;
        $this->durationNumber = '';
        $this->durationUnit   = '';
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
            'activity' => 'required|string|max:500',
        ];

        // if ($this->mode === 'finish') {
        //     $rules['durationNumber'] = 'required|numeric|min:0.1';
        //     $rules['durationUnit'] = 'required|in:minutes,hours,days';
        // }
        
        $validated=$this->validate($rules);

        if ($this->mode == 'add') {
            try {
                ToDoList::create([
                    'activity'        => $this->activity,
                    'company_id'      => Auth::user()->company_id,
                    'created_by'      => Auth::id(),
                ]);

                $this->dispatch('refresh-to-do-list');
                $this->dispatch('update-to-do-count');

                $this->dispatch('swal:modal', [
                    'type' => 'success',
                    'title' => 'To Do created',
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
                $toDo = ToDoList::where('id', $this->toDoId)
                    ->where('company_id', Auth::user()->company_id)
                    ->firstOrFail();

                if ($toDo->company_id !== auth()->user()->company_id) {
                    abort(403, 'Unauthorized access');
                }

                if ($toDo->created_by !== auth()->user()->id) {
                    abort(403, 'Unauthorized access');
                }

                $toDo->update([
                    'activity'        => $this->activity,
                    'updated_by'      => Auth::id()
                    // you usually don't change created_by on edit
                ]);

                $this->dispatch('refresh-to-do-list');

                $this->dispatch('swal:modal', [
                    'type' => 'success',
                    'title' => 'To Do updated',
                    'text' => '',
                ]);
            } catch (\Throwable $e) { 
                $this->dispatch('swal:modal', [
                    'type' => 'error',
                    'title' => 'Error',
                    'text' => $e->getMessage(),
                ]);
            };
        } else if ( $this->mode == 'finish' ) {
            try {
                $toDo = ToDoList::where('id', $this->toDoId)
                    ->where('company_id', Auth::user()->company_id)
                    ->firstOrFail();

                if ($toDo->company_id !== auth()->user()->company_id) {
                    abort(403, 'Unauthorized access');
                }

                if ($toDo->created_by !== auth()->user()->id) {
                    abort(403, 'Unauthorized access');
                }

                $toDo->update([
                    'is_done'        => true,
                    // you usually don't change created_by on edit
                ]);

                // Logbook::create([
                //     'log_date'        => Carbon::today(),
                //     'activity'        => $this->activity,
                //     'duration_number' => $this->durationNumber,
                //     'duration_unit'   => $this->durationUnit,
                //     'company_id'      => Auth::user()->company_id,
                //     'created_by'      => Auth::id(),
                // ]);

                $this->dispatch('refresh-to-do-list');
                $this->dispatch('update-to-do-count');

                $this->dispatch('swal:modal', [
                    'type' => 'success',
                    'title' => 'To Do Finished',
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
        return view('livewire.add-to-do-modal');
    }
}
