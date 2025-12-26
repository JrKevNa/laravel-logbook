<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
 
    <h1 class="mb-4">User Report</h1>

    <div class="row mt-3">
        <div class="col-lg-4">
            <label for="startDate" class="form-label">Start date</label>
            <div class="input-group">
                <input wire:model.live="startDate" type="date" id="startDate"
                    class="form-control @error('startDate') is-invalid @enderror">
            </div>

            @error('startDate')
                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-lg-4">
            <label for="endDate" class="form-label">End date</label>
            <div class="input-group">
                <input wire:model.live="endDate" type="date" id="endDate"
                    class="form-control @error('endDate') is-invalid @enderror">
            </div>

            @error('endDate')
                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-lg-4">
            <label for="assignedUser" class="form-label">User</label>
            <select wire:model.live="selectedUser" id="assignedUser"
                class="form-control @error('selectedUser') is-invalid @enderror">
                <option value="">-- Select User --</option>
                @foreach($companyUsers as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
            @error('selectedUser')
                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-lg-6">
            <button wire:click="previousDay" type="button" class="w-100 btn btn-primary">Previous Day</button>
        </div>
        <div class="col-lg-6">
            <button wire:click="nextDay" type="button" class="w-100 btn btn-success">Next Day</button>
        </div>
    </div>

    @forelse($logsGrouped as $group)
        {{-- <h5 class="mt-4">{{ $group['date'] }}</h5>
        <ul class="list-group">
            @foreach($group['entries'] as $log)
                <li class="list-group-item">
                    {{ $log['activity'] }} - Duration: {{ $log['duration_number'] }} {{ $log['duration_unit'] }}
                </li>
            @endforeach
        </ul> --}}
        <div class="card w-100 mt-3 {{ $loop->last ? 'mb-3' : '' }}">
            <div class="card-body">
                @php
                    // Sum the durations for this day's entries
                    $totalMinutes = collect($group['entries'])->sum(function($log) {
                        return match($log['duration_unit']) {
                            'days' => $log['duration_number'] * 24 * 60,
                            'hours' => $log['duration_number'] * 60,
                            'minutes' => $log['duration_number'],
                            default => 0
                        };
                    });

                    $days = intdiv($totalMinutes, 1440);
                    $remainingMinutes = $totalMinutes % 1440;
                    $hours = intdiv($remainingMinutes, 60);
                    $minutes = $remainingMinutes % 60;
                @endphp

                <h5 class="card-title d-flex justify-content-between align-items-center">
                    <span>{{ $group['user'] }}</span>
                    <span class="badge bg-secondary">
                        Total duration in this user: {{ $days }}d {{ $hours }}h {{ $minutes }}m
                    </span>
                </h5>

                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>Log Date</th>
                            <th>Activity</th>
                            <th>Duration</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($group['entries'] as $log)
                            <tr>
                                <td>{{ $log['log_date'] }}</td>
                                <td>{{ $log['activity'] }}</td>
                                <td>{{ $log['duration_number'] }} {{ $log['duration_unit'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div class="alert alert-primary d-flex align-items-center mt-3" role="alert">
            <i class="bi bi-info-circle-fill me-2 fs-4"></i>
            <div>
                Info alert! No data found
            </div>
        </div>
    @endforelse
</div>
