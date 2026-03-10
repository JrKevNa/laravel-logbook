<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Invoice List</h1>
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
                        placeholder="Search document number..."
                        wire:model.live.debounce.300ms="searchTerm"
                    />
                </div>
            </div>
        </div>

        <div class="col-lg-2">
            <a href="{{ route('invoice-creator') }}"
                type="button" class="btn btn-primary w-100"
            >
                Make Invoice
            </a>
        </div>
    </div>
    
    <div>
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>Document Number</th>
                    <th>Creator</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($invoices as $inv)
                    <tr>
                        <td>{{ $inv->document_number }}</td>
                        <td>{{ $inv->creator->name ?? '—' }}</td>
                        <td>
                            <!-- Edit -->
                            <a href="{{ route('invoice-creator', $inv->id) }}"
                                type="button" class="btn btn-sm btn-primary me-1"
                            >
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <!-- Delete -->
                            <button 
                                class="btn btn-sm btn-danger"
                                wire:click="delete({{ $inv->id }})"
                                wire:confirm="Are you sure you want to delete this invoice?"
                            >
                                <i class="bi bi-trash"></i>
                            </button>


                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-3">
                            No invoice entries found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-3">
            {{ $invoices->links() }}
        </div>
    </div>
</div>
