<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Fingerprint;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AddFingerprintModal extends Component
{
    use AuthorizesRequests;

    public $formTitle = '';
    public $mode = '';

    public $fingerId;
    public $name;
    public $nik;
    public $note;

    #[On('add-fingerprint')]
    public function add() {
        $this->resetValidation();
        $this->formTitle='Add Fingerprint';
        $this->mode = 'add';

        $this->name = '';
        $this->nik = '';
        $this->note = '';
    }

    #[On('edit-fingerprint')]
    public function edit($id) {
        $this->resetValidation();
        $this->formTitle='Edit Fingerprint';
        $this->mode = 'edit';

        $fingerprint = Fingerprint::findOrFail($id);
        $this->authorize('update', $fingerprint);

        $this->fingerId = $fingerprint->id;
        $this->name = $fingerprint->name;
        $this->nik = $fingerprint->nik;
        $this->note = $fingerprint->note;
    }

    public function submit() {

        $rules = [
            'name'  => 'required|string|max:100',
            'nik'  => 'required|string|max:100',
        ];

        $validated=$this->validate($rules);

        if ($this->mode == 'add') {
            $this->authorize('create', Fingerprint::class);

            $fingerprint = Fingerprint::create([
                'name'       => $this->name,
                'nik'        => $this->nik,
                'note'       => $this->note,
                'company_id' => Auth::user()->company_id,
                'created_by' => Auth::id(),
            ]);

            $this->dispatch('refresh-fingerprint');
            $this->dispatch('swal:modal', [
                'type' => 'success',
                'title' => 'Fingerprint Added Succesfully',
                'text' => 'By default is unregistered!',
            ]);
        } else if ($this->mode == 'edit') {
            $fingerprint = Fingerprint::findOrFail($this->fingerId);

            $this->authorize('update', $fingerprint);

            $fingerprint->update([
                'name'       => $this->name,
                'nik'        => $this->nik,
                'note'       => $this->note,
                'updated_by' => Auth::id(),
            ]);

            $this->dispatch('refresh-fingerprint');
            $this->dispatch('swal:modal', [
                'type' => 'success',
                'title' => 'Fingerprint Updated Succesfully',
            ]);
        }

        return;
    }

    public function render()
    {
        return view('livewire.add-fingerprint-modal');
    }
}
