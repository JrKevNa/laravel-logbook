<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Logbook;
use Livewire\Component;

class DailyReport extends Component
{
    
    public $startDate;
    public $endDate;
    public $companyUsers = [];
    public $selectedUser;
    public $logsGrouped = [];

    public function mount()
    {
        $this->startDate = Carbon::today()->format('Y-m-d');
        $this->endDate = Carbon::today()->format('Y-m-d');

        if (auth()->user()->hasRole('admin')) {
            // Admin sees all users in the company
            $this->companyUsers = User::where('company_id', auth()->user()->company_id)->get();
        } else {
            // Non-admin sees only themselves
            $this->companyUsers = User::where('id', auth()->id())->get();
        }

        $this->fetchLogs();
    }

    public function previousDay()
    {
        // Use current startDate or today if empty
        $current = $this->startDate ? Carbon::parse($this->startDate) : Carbon::today();

        // Subtract one day
        $previous = $current->subDay();

        // Set startDate and endDate
        $this->startDate = $previous->format('Y-m-d');
        $this->endDate = $previous->format('Y-m-d');

        $this->fetchLogs();
    }

    // public function updatedStartDate($value)
    // {
    //     $this->fetchLogs();
    // }

    // public function updatedEndDate($value)
    // {
    //     $this->fetchLogs();
    // }

    // public function updatedUserId($value)
    // {
    //     $this->fetchLogs();
    // }

    public function updated($propertyName, $value)
    {
        if (in_array($propertyName, ['startDate', 'endDate', 'selectedUser'])) {
            $this->fetchLogs();
        }
    }


    public function nextDay()
    {
        // Use current startDate or today if empty
        $current = $this->startDate ? Carbon::parse($this->startDate) : Carbon::today();

        // Subtract one day
        $next = $current->addDay();

        // Set startDate and endDate
        $this->startDate = $next->format('Y-m-d');
        $this->endDate = $next->format('Y-m-d');

        $this->fetchLogs();
    }

    public function fetchLogs()
    {
        $logsQuery = Logbook::with('creator') // eager-load the user
            ->where('company_id', auth()->user()->company_id)
            ->whereBetween('log_date', [$this->startDate, $this->endDate]);

        // filter by selected user if any
        if ($this->selectedUser) {
            if ($this->selectedUser != auth()->id() && !auth()->user()->hasRole('admin')) {
                abort(403, 'Unauthorized: You can only view your own logs.');
            }
            $logsQuery->where('created_by', $this->selectedUser);
        } else {
            // No user selected
            if (!auth()->user()->hasRole('admin')) {
                // Regular users can only see themselves
                $logsQuery->where('created_by', auth()->id());
            }
        }

        // fetch logs ordered by date
        $logs = $logsQuery->orderBy('log_date', 'desc')->get();

        // Group logs by day
        $this->logsGrouped = $logs->groupBy(function($log) {
            return Carbon::parse($log->log_date)->format('Y-m-d');
        })->map(function($dayLogs, $date) {
            return [
                'date' => $date,
                'entries' => $dayLogs->toArray(),
            ];
        })->values()->toArray();
    }


    public function render()
    {
        return view('livewire.daily-report');
    }
}
