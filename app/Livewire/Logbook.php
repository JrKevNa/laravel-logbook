<?php

namespace App\Livewire;

use App\Models\Logbook as LogbookModel;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Logbook extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $searchTerm = '';

    public $showModal = false;
    
    #[On('refresh-logbook')]
    public function refreshLogbook() {
        $this->resetPage();
    }

    public function delete($id)
    {
        // // MUST: user must be logged in
        // if (!auth()->check()) {
        //     abort(403, 'You must be logged in.');
        // }

        // // MUST: user must have permission
        // if (!auth()->user()->hasRole(['user'])) {
        //     abort(403, 'Unauthorized.');
        // }

        try {
            $logbook = LogbookModel::where('id', $id)
                ->where('company_id', auth()->user()->company_id)
                ->where('created_by', auth()->user()->id)
                ->firstOrFail(); // aborts if not found

            $this->authorize('delete', $logbook);

            $logbook->delete();

            $this->dispatch('swal:modal', [
                'type' => 'success',
                'title' => 'Deleted!',
                'text' => 'Logbook has been deleted.'
            ]);

            $this->refreshLogbook();
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
        $logbooks = LogbookModel::with('creator')      // eager load user relationship
            ->where('company_id', Auth::user()->company_id)
            ->where('created_by', Auth::user()->id)
            ->where('activity', 'like', '%' . $this->searchTerm . '%')
            ->orderBy('log_date', 'desc')
            ->paginate(10);

        $totalMinutes = $logbooks->sum(function($log) {
            return match($log->duration_unit) {
                'days' => $log->duration_number * 24 * 60,
                'hours' => $log->duration_number * 60,
                'minutes' => $log->duration_number,
                default => 0
            };
        });

        $days = intdiv($totalMinutes, 1440); // 1440 minutes in a day
        $remainingMinutes = $totalMinutes % 1440;

        $hours = intdiv($remainingMinutes, 60);
        $minutes = $remainingMinutes % 60;

        return view('livewire.logbook', [
            'logbooks' => $logbooks,
            'totalDays' => $days,
            'totalHours' => $hours,
            'totalMinutes' => $minutes,
        ]);
    }
}
