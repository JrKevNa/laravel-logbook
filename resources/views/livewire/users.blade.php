<div>
    {{-- The whole world belongs to you. --}}
    <h1 class="mb-4">Users</h1>

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
                        placeholder="Search user name and email..."
                        wire:model.live.debounce.300ms="searchTerm"
                    />
                </div>
            </div>
        </div>

        <div class="col-lg-2">
            <button
                wire:click="$dispatch('add-user')"
                type="button" class="btn btn-primary w-100"
                data-bs-toggle="modal" data-bs-target="#addUserModal">
                Add User
            </button>
        </div>
    </div>

    <div>
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>NIK</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->nik }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->roles->pluck('name')->join(', ') }}</td>
                        <td>
                            <!-- Edit -->
                            <button 
                                class="btn btn-sm btn-primary me-1"
                                data-bs-toggle="modal" data-bs-target="#addUserModal"
                                wire:click="$dispatch('edit-user', { id: {{ $user->id }} })"
                                {{-- @click="$dispatch('edit-logbook',{id:{{$log->id}}})" --}}
                            >
                                <i class="bi bi-pencil-square"></i>
                            </button>

                            <!-- Delete -->
                            {{-- <button 
                                class="btn btn-sm btn-danger"
                                wire:click="delete({{ $user->id }})"
                                wire:confirm="Are you sure you want to delete this logbook?"
                            >
                                <i class="bi bi-trash"></i>
                            </button> --}}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-3">
                            No User entries found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-3">
            {{ $users->links() }}
        </div>
    </div>
    <livewire:add-user-modal />
</div>
