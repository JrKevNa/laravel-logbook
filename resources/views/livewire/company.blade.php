<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    <h1 class="mb-4">Company</h1>

    <form wire:submit.prevent="submit">
        <div class="row">
            <div class="col-md-12">
                <div class="form-floating">
                    <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Name">
                    <label for="name">Name</label>
                </div>
                @error('name')
                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </form>
</div>
