<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <h1 class="mb-4">To Do List</h1>

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
                        placeholder="Search to do activity..."
                        wire:model.live.debounce.300ms="searchTerm"
                    />
                </div>
            </div>
        </div>

        <div class="col-lg-2">
            <button
                wire:click="$dispatch('add-to-do')"
                type="button" class="btn btn-primary w-100"
                data-bs-toggle="modal" data-bs-target="#addToDoModal">
                Add To Do
            </button>
        </div>
    </div>

    <div>
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>Is Done</th>
                    <th>Created Date</th>
                    <th>Activity</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($toDoList as $toDo)
                    <tr>
                        <td>
                            @if($toDo->is_done)
                                <i class="bi bi-check-circle-fill text-success"></i>
                            @else
                                <i class="bi bi-x-circle-fill text-danger"></i>
                            @endif
                        </td>
                        <td>{{ $toDo->created_at ?? '—' }}</td>
                        <td>
                            @php
                                $raw = str($toDo->activity)->limit(200, '…');
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
                        <td>
                            @if($toDo->is_done == false)
                                <!-- Finish -->
                                <button 
                                    class="btn btn-sm btn-success me-1"
                                    data-bs-toggle="modal" data-bs-target="#addToDoModal"
                                    wire:click="$dispatch('finish-to-do', { id: {{ $toDo->id }} })"
                                >
                                    <i class="bi bi-check-circle"></i>
                                </button>

                                <!-- Edit -->
                                <button 
                                    class="btn btn-sm btn-primary me-1"
                                    data-bs-toggle="modal" data-bs-target="#addToDoModal"
                                    wire:click="$dispatch('edit-to-do', { id: {{ $toDo->id }} })"
                                >
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <!-- Delete -->
                                <button 
                                    class="btn btn-sm btn-danger"
                                    wire:click="delete({{ $toDo->id }})"
                                    wire:confirm="Are you sure you want to delete this to do?"
                                >
                                    <i class="bi bi-trash"></i>
                                </button>
                            @else
                                <span class="text-success">
                                    Finished at {{ $toDo->updated_at->format('d M Y H:i') }}
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-3">
                            No to do entries found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-3">
            {{ $toDoList->links() }}
        </div>
    </div>
    <livewire:add-to-do-modal />
</div>
