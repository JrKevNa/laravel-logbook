<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Fingerprint;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Fingerprints extends Component
{
    use AuthorizesRequests;
    use WithPagination;

    public $selectedStatus;
    public string $searchTerm = '';

    public function register(int $fingerprintId): void
    {
        $fingerprint = Fingerprint::where('id', $fingerprintId)
            ->where('company_id', auth()->user()->company_id)
            ->firstOrFail();

        $this->authorize('update', $fingerprint);

        $fingerprint->update([
            'enroll_fingerprint' => true,
            'updated_by' => auth()->id(),
        ]);

        $this->dispatch('swal:modal', [
            'type' => 'success',
            'title' => 'Fingerprint registered',
            'text' => $fingerprint->user->name . ' is now registered.',
        ]);
    }

    public function deregister(int $fingerprintId): void
    {
        $fingerprint = Fingerprint::where('id', $fingerprintId)
            ->where('company_id', auth()->user()->company_id)
            ->firstOrFail();

        $this->authorize('update', $fingerprint);

        $fingerprint->update([
            'enroll_fingerprint' => false,
            'updated_by' => auth()->id(),
        ]);

        $this->dispatch('swal:modal', [
            'type' => 'success',
            'title' => 'Fingerprint deregistered',
            'text' => $fingerprint->user->name . ' is now deregistered.',
        ]);
    }

    public function render()
    {
        $fingerprints = Fingerprint::with('user')
            ->where('company_id', auth()->user()->company_id)
            ->whereHas('user', function ($q) {
                $q->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('nik', 'like', '%' . $this->searchTerm . '%');
                });
            })
            ->when($this->selectedStatus === 'registered', function ($q) {
                $q->where('enroll_fingerprint', true);
            })
            ->when($this->selectedStatus === 'not_registered', function ($q) {
                $q->where('enroll_fingerprint', false);
            })
            ->orderBy('enroll_fingerprint') // false (0) first = NOT registered
            ->orderByDesc('created_at')     // latest first
            ->paginate(10);


        return view('livewire.fingerprints', [
            'fingerprints' => $fingerprints,
        ]);
    }
}
