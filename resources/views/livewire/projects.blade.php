<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <h1 class="mb-4">Projects</h1>

    <div class="row">
        <div class="col-lg-10">
            <div class="mb-3">
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" class="form-control" placeholder="Search project name..."
                        wire:model.live.debounce.300ms="searchTerm" />
                </div>
            </div>
        </div>

        <div class="col-lg-2">
            <button wire:click="$dispatch('add-project')" type="button" class="btn btn-primary w-100"
                data-bs-toggle="modal" data-bs-target="#addProjectModal">
                Add Project
            </button>
        </div>
    </div>

    <div>
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>Is Done</th>
                    <th>Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Requested By</th>
                    <th>Worked By</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($projects as $project)
                    <tr>
                        <td>
                            @if ($project->is_done)
                                <i class="bi bi-check-circle-fill text-success"></i>
                            @else
                                <i class="bi bi-x-circle-fill text-danger"></i>
                            @endif
                        </td>
                        <td>{{ str($project->name)->limit(40) }}</td>
                        <td>{{ $project->start_date ?? '—' }}</td>
                        <td>{{ $project->end_date ?? '—' }}</td>
                        <td>{{ $project->requested_by ?? '-' }}</td>
                        <td>{{ $project->worker->name ?? '-' }}</td>
                        <td>
                            @if($project->is_done == false)
                                <!-- Finish -->
                                <button class="btn btn-sm btn-success me-1" wire:click="finish({{ $project->id }})"
                                    wire:confirm="Are you sure you want to finish this project?">
                                    <i class="bi bi-check-circle"></i>
                                </button>

                                <!-- Detail -->
                                <a href="{{ route('detail-project', $project->id) }}" class="btn btn-sm btn-secondary position-relative me-1">
                                    <i class="bi bi-journal"></i>
                                    @if($project->remaining_details_count > 0)
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            {{ $project->remaining_details_count }}
                                        </span>
                                    @endif
                                </a>

                                <!-- Edit -->
                                <button class="btn btn-sm btn-primary me-1" data-bs-toggle="modal"
                                    data-bs-target="#addProjectModal"
                                    wire:click="$dispatch('edit-project', { id: {{ $project->id }} })"
                                    {{-- @click="$dispatch('edit-logbook',{id:{{$log->id}}})" --}}>
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <!-- Delete -->
                                <button class="btn btn-sm btn-danger" wire:click="delete({{ $project->id }})"
                                    wire:confirm="Are you sure you want to delete this project?">
                                    <i class="bi bi-trash"></i>
                                </button>
                            @else
                                <!-- Detail -->
                                <a href="{{ route('detail-project', $project->id) }}" class="btn btn-sm btn-secondary me-1">
                                    <i class="bi bi-journal"></i>
                                </a>

                                <!-- Edit -->
                                <button class="btn btn-sm btn-primary me-1" data-bs-toggle="modal"
                                    data-bs-target="#addProjectModal"
                                    wire:click="$dispatch('edit-project', { id: {{ $project->id }} })"
                                    {{-- @click="$dispatch('edit-logbook',{id:{{$log->id}}})" --}}>
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <!-- Delete -->
                                <button class="btn btn-sm btn-danger" wire:click="delete({{ $project->id }})"
                                    wire:confirm="Are you sure you want to delete this project?">
                                    <i class="bi bi-trash"></i>
                                </button>
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
            {{ $projects->links() }}
        </div>
    </div>
    <livewire:add-project-modal />
</div>
