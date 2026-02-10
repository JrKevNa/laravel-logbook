<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Fingerprint</h1>
    </div>

    <div class="row">
        <div class="col-lg-5">
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
        <div class="col-lg-5">
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
        <div class="col-lg-2">
            <button
                wire:click="$dispatch('add-fingerprint')"
                type="button" class="btn btn-primary w-100"
                data-bs-toggle="modal" data-bs-target="#addFingerprintModal">
                Add Fingerprint
            </button>
        </div>
    </div>

    <div>
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>Username</th>
                    <th>NIK</th>
                    <th class="text-center">Upload user info to machine</th>
                    <th class="text-center">Enroll Fingerprint</th>
                    <th class="text-center">Download user info to program</th>
                    <th class="text-center">Upload user to all machine</th>
                    <th class="text-center">Give Password</th>
                    <th>Note</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($fingerprints as $fingerprint)
                    <tr>
                        <td>{{ $fingerprint->name }}</td>
                        <td>{{ $fingerprint->nik ?? '—' }}</td>
                        <td class="text-center">
                            <!-- Upload user info to machine -->
                            <input
                                type="checkbox"
                                wire:click="toggleUpdate({{ $fingerprint->id }}, 'upload_user_info_to_machine')"
                                {{ $fingerprint->upload_user_info_to_machine ? 'checked' : '' }}
                            >
                        </td>
                        <td class="text-center">
                            <!-- Enroll fingerprint -->
                            <input
                                type="checkbox"
                                wire:click="toggleUpdate({{ $fingerprint->id }}, 'enroll_fingerprint')"
                                {{ $fingerprint->enroll_fingerprint ? 'checked' : '' }}
                            >
                        </td>
                        <td class="text-center">
                            <!-- Download user info to program -->
                            <input
                                type="checkbox"
                                wire:click="toggleUpdate({{ $fingerprint->id }}, 'download_user_info_to_program')"
                                {{ $fingerprint->download_user_info_to_program ? 'checked' : '' }}
                            >
                        </td>
                        <td class="text-center">
                            <!-- Upload user info to all machines -->
                            <input
                                type="checkbox"
                                wire:click="toggleUpdate({{ $fingerprint->id }}, 'upload_user_info_to_all_machine')"
                                {{ $fingerprint->upload_user_info_to_all_machine ? 'checked' : '' }}
                            >
                        </td>
                        <td class="text-center">
                            <!-- Give Password -->
                            <input
                                type="checkbox"
                                wire:click="toggleUpdate({{ $fingerprint->id }}, 'give_password')"
                                {{ $fingerprint->give_password ? 'checked' : '' }}
                            >
                        </td>
                        <td>
                            @php
                                $raw = str($fingerprint->note)->limit(80, '…');
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
                        <td class="text-center">
                            <button 
                                class="btn btn-sm btn-primary"
                                data-bs-toggle="modal" data-bs-target="#addFingerprintModal"
                                wire:click="$dispatch('edit-fingerprint', { id: {{ $fingerprint->id }} })"
                            >
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button 
                                class="btn btn-sm btn-danger"
                                wire:click="delete({{ $fingerprint->id }})"
                                wire:confirm="Are you sure you want to delete this fingerprint data?"
                            >
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-3">
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
    <livewire:add-fingerprint-modal />
</div>
