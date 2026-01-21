<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Fingerprint</h1>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="mb-3">
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                    </span>
                    <input 
                        type="text" 
                        class="form-control" 
                        placeholder="Search user by name and nik..."
                        wire:model.live.debounce.300ms="searchTerm"
                    />
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            {{-- <label for="fingerprintStatus" class="form-label">Fingerprint Status</label> --}}
            <select
                wire:model.live="selectedStatus"
                id="fingerprintStatus"
                class="form-control @error('selectedStatus') is-invalid @enderror"
            >
                <option value="all">All</option>
                <option value="registered">Registered</option>
                <option value="not_registered">Not Registered</option>
            </select>

            @error('selectedStatus')
                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div>
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>Username</th>
                    <th>NIK</th>
                    <th class="text-center">Enroll Fingerprint</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($fingerprints as $fingerprint)
                    <tr>
                        <td>{{ $fingerprint->user->name }}</td>
                        <td>{{ $fingerprint->user->nik ?? '—' }}</td>
                        <td class="text-center">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                disabled
                                {{ $fingerprint->enroll_fingerprint ? 'checked' : '' }}
                            >
                        </td>
                        <td class="text-center">
                            @if ($fingerprint->enroll_fingerprint)
                                <button
                                    type="button"
                                    class="btn btn-sm btn-outline-danger"
                                    wire:click="deregister({{ $fingerprint->id }})"
                                >
                                    Deregister
                                </button>
                            @else
                                <button
                                    type="button"
                                    class="btn btn-sm btn-outline-success"
                                    wire:click="register({{ $fingerprint->id }})"
                                >
                                    Register
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-3">
                            No fingerprint entries found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-3">
            {{ $fingerprints->links() }}
        </div>
    </div>
</div>
