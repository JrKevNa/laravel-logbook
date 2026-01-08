<div>
    {{-- In work, do what you enjoy. --}}
    <h1 class="mb-4">{{ $project->name }}</h1>

    <div class="row">
        <div class="col-lg-10">
            <div class="mb-3">
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" class="form-control" placeholder="Search activity name..."
                        wire:model.live.debounce.300ms="searchTerm" />
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <button wire:click="$dispatch('add-detail-project', { id: {{ $project->id }} })" type="button" class="btn btn-primary w-100"
                data-bs-toggle="modal" data-bs-target="#addDetailProjectModal">
                Add Detail Project
            </button>
        </div>
    </div>

    <div>
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>Is Done</th>
                    <th>Request Date</th>
                    <th>Activity</th>
                    <th>Requested By</th>
                    <th>Worked By</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($detailProjects as $detailProject)
                    <tr>
                        <td>
                            @if ($detailProject->is_done)
                                <i class="bi bi-check-circle-fill text-success"></i>
                            @else
                                <i class="bi bi-x-circle-fill text-danger"></i>
                            @endif
                        </td>
                        <td>{{ $detailProject->request_date }}</td>
                        <td>
                            @php
                                $raw = str($detailProject->activity)->limit(200, '…');
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
                        <td>{{ $detailProject->requested_by ?? '-' }}</td>
                        <td>{{ $detailProject->worker->name ?? '-' }}</td>
                        <td>
                            @if($detailProject->is_done == false)
                                <!-- Finish -->
                                <button class="btn btn-sm btn-success me-1" data-bs-toggle="modal"
                                    data-bs-target="#addDetailProjectModal"
                                    wire:click="$dispatch('finish-detail-project', { projectId: {{ $project->id }}, detailId: {{ $detailProject->id }} })"
                                    {{-- @click="$dispatch('edit-logbook',{id:{{$log->id}}})" --}}>
                                    <i class="bi bi-check-lg"></i>
                                </button>

                                <!-- Edit -->
                                <button class="btn btn-sm btn-primary me-1" data-bs-toggle="modal"
                                    data-bs-target="#addDetailProjectModal"
                                    wire:click="$dispatch('edit-detail-project', { projectId: {{ $project->id }}, detailId: {{ $detailProject->id }} })"
                                    {{-- @click="$dispatch('edit-logbook',{id:{{$log->id}}})" --}}>
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <!-- Delete -->
                                <button class="btn btn-sm btn-danger" wire:click="delete({{ $detailProject->id }})"
                                    wire:confirm="Are you sure you want to delete this project?">
                                    <i class="bi bi-trash"></i>
                                </button>
                            @else
                                <span class="text-success">
                                    Finished at {{ $detailProject->updated_at->format('d M Y H:i') }}
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-3">
                            No Project entries found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-3">
            {{ $detailProjects->links() }}
        </div>
    </div>
    <livewire:add-detail-project-modal />
</div>
