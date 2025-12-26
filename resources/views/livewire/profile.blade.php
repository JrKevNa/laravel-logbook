<div>
    {{-- The best athlete wants his opponent at his best. --}}
    <h1 class="mb-4">Profile</h1>
    
    <form wire:submit.prevent="submit">
        <div class="row">
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Name">
                    <label for="name">Name</label>
                </div>
                @error('name')
                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-6">
                <div class="form-floating">
                    <input type="text" wire:model="nik" class="form-control @error('nik') is-invalid @enderror" id="nik" placeholder="NIK">
                    <label for="nik">NIK</label>
                </div>
                @error('nik')
                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                @enderror
            </div>
        </div>


        <div class="form-floating mt-3">
            <input type="email" wire:model="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email">
            <label for="email">Email</label>
        </div>
        @error('email')
            <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
        @enderror

        <select wire:model="selectedRole" id="role" class="form-control mt-3 @error('selectedRole') is-invalid @enderror" disabled required>
            <option value="">-- Select Role --</option>
            @foreach($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
            @endforeach
        </select>
        @error('selectedRole')
            <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
        @enderror

        <button class="btn btn-primary w-100 mt-3"
                type="submit"
                wire:loading.attr="disabled"
                wire:target="submit">

            <span wire:loading.remove wire:target="submit">
                Update Profile
            </span>

            <span wire:loading wire:target="submit">
                <div class="spinner-border spinner-border-sm" role="status"></div>
            </span>
        </button>
    </form>
</div>
