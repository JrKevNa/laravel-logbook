<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <div wire:ignore.self class="modal modal-lg fade" id="addUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form wire:submit.prevent="submit">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ $formTitle }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating">
                            <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Name">
                            <label for="name">Name</label>
                        </div>
                        @error('name')
                            <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                        @enderror

                        <div class="form-floating mt-3">
                            <input type="text" wire:model="nik" class="form-control @error('nik') is-invalid @enderror" id="nik" placeholder="NIK">
                            <label for="nik">NIK</label>
                        </div>
                        @error('nik')
                            <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                        @enderror

                        <div class="form-floating mt-3">
                            <input type="email" wire:model="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email">
                            <label for="email">Email</label>
                        </div>
                        @error('email')
                            <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                        @enderror

                        <select wire:model="selectedRole" id="role" class="form-control mt-3 @error('selectedRole') is-invalid @enderror" required>
                            <option value="">-- Select Role --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('selectedRole')
                            <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                        @enderror

                        {{-- @if($mode === 'add')
                            <div class="form-floating mt-3">
                                <input type="password" wire:model="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password">
                                <label for="password">Password</label>
                            </div>
                            @error('password')
                                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                            @enderror

                            <div class="form-floating mt-3">
                                <input type="password" wire:model="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" placeholder="Confirm Password">
                                <label for="password_confirmation">Confirm Password</label>
                            </div>
                            @error('password_confirmation')
                                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                            @enderror
                        @else
                            <div class="form-check mt-3">
                                <input type="checkbox" wire:model.live="wantToResetPassword" class="form-check-input" id="resetPasswordCheck">
                                <label class="form-check-label" for="resetPasswordCheck">Reset Password</label>
                            </div>

                            @if($wantToResetPassword)
                                <div class="form-floating mt-3">
                                    <input type="password" wire:model="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password">
                                    <label for="password">Password</label>
                                </div>
                                @error('password')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror

                                <div class="form-floating mt-3">
                                    <input type="password" wire:model="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" placeholder="Confirm Password">
                                    <label for="password_confirmation">Confirm Password</label>
                                </div>
                                @error('password_confirmation')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            @endif
                        @endif --}}

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
