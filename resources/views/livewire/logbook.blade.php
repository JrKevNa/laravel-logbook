<div>
    {{-- The whole world belongs to you. --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Logbook</h1>
        <span class="badge bg-secondary fs-5 px-3 py-2">Total duration in this page: {{ $totalDays }}d {{ $totalHours }}h {{ $totalMinutes }}m</span>
    </div>


    <div class="row">
        <div class="col-lg-10">
            <div class="mb-3">
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                    </span>
                    <input 
                        type="text" 
                        class="form-control" 
                        placeholder="Search logbook activity..."
                        wire:model.live.debounce.300ms="searchTerm"
                    />
                </div>
            </div>
        </div>

        <div class="col-lg-2">
            <button
                wire:click="$dispatch('add-logbook')"
                type="button" class="btn btn-primary w-100"
                data-bs-toggle="modal" data-bs-target="#addLogbookModal">
                Add Logbook
            </button>
        </div>
    </div>

    <div>
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>Log Date</th>
                    <th>Created By</th>
                    <th>Activity</th>
                    <th>Duration</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($logbooks as $log)
                    <tr>
                        <td>{{ $log->log_date }}</td>
                        <td>{{ $log->creator->name ?? '—' }}</td>
                        <td>
                            @php
                                $raw = str($log->activity)->limit(80, '…');
                                $text = e($raw);

                                $text = preg_replace(
                                    '/(https?:\/\/[^\s<]+)/',
                                    '<a href="$1" target="_blank" rel="noopener noreferrer">$1</a>',
                                    $text
                                );

                                $text = nl2br($text);
                            @endphp

                            {!! $text !!}
                        </td>

                        <td>{{ $log->duration_number }} {{ $log->duration_unit }}</td>
                        <td>
                            <!-- Edit -->
                            <button 
                                class="btn btn-sm btn-primary me-1"
                                data-bs-toggle="modal" data-bs-target="#addLogbookModal"
                                wire:click="$dispatch('edit-logbook', { id: {{ $log->id }} })"
                                {{-- @click="$dispatch('edit-logbook',{id:{{$log->id}}})" --}}
                            >
                                <i class="bi bi-pencil-square"></i>
                            </button>

                            <!-- Delete -->
                            <button 
                                class="btn btn-sm btn-danger"
                                wire:click="delete({{ $log->id }})"
                                wire:confirm="Are you sure you want to delete this logbook?"
                            >
                                <i class="bi bi-trash"></i>
                            </button>


                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-3">
                            No logbook entries found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-3">
            {{ $logbooks->links() }}
        </div>
    </div>
    <livewire:add-logbook-modal />
    {{-- @livewire('add-logbook-modal') --}}
</div>
