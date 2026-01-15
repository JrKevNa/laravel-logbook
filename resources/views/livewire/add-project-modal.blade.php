<div>
    {{-- The Master doesn't talk, he acts. --}}
   <div wire:ignore.self class="modal modal-lg fade" id="addProjectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form wire:submit.prevent="submit">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ $formTitle }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <label for="name" class="form-label">Program Name</label>
                        <div>
                            <input wire:model="name" type="text" step="0.01" id="name"
                                class="form-control @error('name') is-invalid @enderror" required>
                            @error('name')
                                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <label for="name" class="form-label mt-3">Worked By</label>
                                <select wire:model="workedBy" id="role" class="form-control @error('workedBy') is-invalid @enderror" required>
                                    <option value="">-- Select User --</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('workedBy')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="col-lg-6">
                                <label for="name" class="form-label mt-3">RequestedBy</label>
                                <div>
                                    <input wire:model="requestedBy" type="text" step="0.01" id="requestedBy"
                                        class="form-control @error('requestedBy') is-invalid @enderror" required>
                                    @error('requestedBy')
                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <label for="startDate" class="form-label mt-3">Start date</label>
                                <div class="input-group">
                                    <input wire:model="startDate" type="date" id="startDate"
                                        class="form-control @error('startDate') is-invalid @enderror" required>
                                </div>
                                @error('startDate')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-lg-6">
                                <label for="endDate" class="form-label mt-3">End date</label>
                                <div class="input-group">
                                    <input wire:model="endDate" type="date" id="endDate"
                                        class="form-control @error('endDate') is-invalid @enderror" required>
                                </div>
                                @error('endDate')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        @if($mode === 'finish')
                            <div class="row mt-3 mb-3">
                                <div class="col-lg-6">
                                    <label for="name" class="form-label">Duration</label>
                                    <div>
                                        <input wire:model="durationNumber" type="number" step="0.01" id="durationNumber"
                                            class="form-control @error('durationNumber') is-invalid @enderror">
                                        @error('durationNumber')
                                            <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label for="durationUnit" class="form-label">Duration Unit</label>
                                    <select wire:model="durationUnit" id="durationUnit"
                                        class="form-control @error('durationUnit') is-invalid @enderror">
                                        <option value="">-- Select Unit --</option>
                                        <option value="minutes">Minutes</option>
                                        <option value="hours">Hours</option>
                                        <option value="days">Days</option>
                                    </select>
                                    @error('durationUnit')
                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary"
                                type="submit"
                                wire:loading.attr="disabled"
                                wire:target="submit">

                            <span wire:loading.remove wire:target="submit">
                                Save
                            </span>

                            <span wire:loading wire:target="submit">
                                <div class="spinner-border spinner-border-sm" role="status"></div>
                            </span>
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
