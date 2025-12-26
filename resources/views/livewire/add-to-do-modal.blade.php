<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    <div wire:ignore.self class="modal modal-lg fade" id="addToDoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form wire:submit.prevent="submit">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ $formTitle }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <label for="activity" class="form-label">Activity</label>
                        <textarea wire:model="activity" class="mb-3 form-control @error('activity') is-invalid @enderror" id="activity"
                            rows="3">
                        </textarea>

                        @error('activity')
                            <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                        @enderror

                        {{-- @if($mode === 'finish')
                            <div class="row mb-3">
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
                        @endif --}}
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary"
                                type="submit"
                                wire:loading.attr="disabled"
                                wire:target="submit">

                            <span wire:loading.remove wire:target="submit">
                                Submit
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