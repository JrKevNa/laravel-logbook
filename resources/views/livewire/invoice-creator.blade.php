<div class="mt-5 mb-5">
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <h1 class="mb-4">Invoice Creator</h1>

    <div class="accordion mb-3" id="formatHelp">
        <div class="accordion-item">
            <h2 class="accordion-header" id="formatHelpHeading">
                <button
                    class="accordion-button collapsed"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#formatHelpBody"
                    aria-expanded="false"
                    aria-controls="formatHelpBody"
                >
                    Text Formatting Help
                </button>
            </h2>

            <div
                id="formatHelpBody"
                class="accordion-collapse collapse"
                aria-labelledby="formatHelpHeading"
                data-bs-parent="#formatHelp"
            >
                <div class="accordion-body">

                    <table class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th width="30%">Input</th>
                                <th width="70%">Result</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>**Bold**</code></td>
                                <td><strong>Bold</strong></td>
                            </tr>
                            <tr>
                                <td><code>*Italic*</code></td>
                                <td><em>Italic</em></td>
                            </tr>
                            <tr>
                                <td><code>__Underline__</code></td>
                                <td><u>Underline</u></td>
                            </tr>
                            <tr>
                                <td><code>~~Strike~~</code></td>
                                <td><del>Strike</del></td>
                            </tr>
                            <tr>
                                <td><code>||Highlight||</code></td>
                                <td>
                                    <span style="background:#e0e0e0; padding:2px 4px;">
                                        Highlight
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><code>***Bold Italic***</code></td>
                                <td>
                                    <strong><em>Bold Italic</em></strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <label for="header" class="form-label">Header</label>
            <textarea wire:model="header" class="mb-3 form-control @error('header') is-invalid @enderror" id="header" disabled
                rows="4">
            </textarea>

            @error('header')
                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-lg-6">
            <label for="documentNumber" class="form-label">Document Number</label>
            <textarea wire:model="documentNumber" placeholder="No. : xxx/INV/MG-XXX/02/2026" class="mb-3 form-control @error('documentNumber') is-invalid @enderror" id="header"
                rows="4">
            </textarea>

            @error('documentNumber')
                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="row mt-3">
        <label for="name" class="form-label text-center">Title</label>
        <div class="col-lg-12">
            <div>
                <input wire:model="title" type="text" id="title" class="form-control @error('title') is-invalid @enderror" required>
                @error('title')
                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <label for="name" class="form-label mt-3 text-center">Content</label>
        @foreach ($sections as $i => $section)
            <div class="col-lg-3 mb-3">
                {{-- <label class="form-label">
                    {{ $section['label'] }}
                </label> --}}
                <input wire:model="sections.{{ $i }}.label" type="text" id="title" class="form-control" disabled>
            </div>

            <div class="col-lg-9 mb-3">
                <textarea
                    wire:model="sections.{{ $i }}.value"
                    class="form-control"
                    rows="3"
                ></textarea>
            </div>
        @endforeach
    </div>

    <div class="row">
        <div class="col-lg-6">
            <label class="form-label">Amount</label>

            <div
                x-data="{
                    raw: @entangle('amount'),
                    display: '',
                    format() {
                        if (this.raw === null || this.raw === '' || isNaN(this.raw)) {
                            this.display = '';
                            return;
                        }

                        this.display = Number(this.raw).toLocaleString('id-ID');
                    }
                }"
                x-init="format()"
            >
                <input
                    type="text"
                    x-model="display"
                    @input="
                        raw = display.replace(/[^0-9]/g, '');
                        format();
                    "
                    class="form-control"
                    placeholder="Enter the amount"
                    inputmode="numeric"
                >
            </div>

            @error('amount')
                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
            @enderror
        </div>


        <div class="col-lg-6">
            <label for="dayDate" class="form-label">Document Signature</label>
            <div class="row mb-3">
                <div class="col-lg-6">
                    <input wire:model="city" type="text" id="title" class="form-control" @error('city') is-invalid @enderror disabled>

                    @error('city')
                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                    @enderror                    
                </div>

                <div class="col-lg-6">
                    <input wire:model="dayDate" type="text" id="title" class="form-control" @error('dayDate') is-invalid @enderror disabled>
                    @error('dayDate')
                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-lg-12">
                    <input wire:model="name" type="text" id="title" placeholder="Your name" class="form-control" @error('name') is-invalid @enderror disabled>

                    @error('name')
                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                    @enderror                    
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <input wire:model="position" type="text" id="title" placeholder="Your division" class="form-control" @error('position') is-invalid @enderror disabled>

                    @error('position')
                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                    @enderror                    
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <label class="form-label">Note</label>
            <input wire:model="note" type="text" id="title" class="form-control" disabled>
           
            @error('note')
                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
            @enderror
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-6">
            <button wire:click="saveInvoice" class="btn btn-success w-100 mt-3">
                Save Invoice
            </button>
        </div>
        <div class="col-lg-6">
            <button wire:click="print" class="btn btn-primary w-100 mt-3">
                Print
            </button>
        </div>
    </div>
</div>

<script>
    window.addEventListener('open-print', () => {
        window.open('{{ route('invoice.print') }}', '_blank');
    });
    
    window.addEventListener('scroll-to-top', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
</script>
