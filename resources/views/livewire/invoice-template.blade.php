<div>
    {{-- The Master doesn't talk, he acts. --}}
    <h1 class="mb-4">Document Template</h1>

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

    <form wire:submit.prevent="submit">
        <div class="row mb-3">
            <div class="col-lg-3">
                <label for="header" class="form-label">Header</label>
            </div>
            <div class="col-lg-9">
                <textarea wire:model="header" class="form-control @error('header') is-invalid @enderror" id="header" required
                    rows="4">
                </textarea>

                @error('header')
                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="row">
            <label class="form-label mt-3 text-center">Content</label>

            @foreach ($sections as $i => $section)

                <div class="col-lg-3 mb-3">
                    <input
                        wire:model="sections.{{ $i }}.label"
                        type="text"
                        class="form-control"
                        placeholder="Label"
                    >
                </div>

                <div class="col-lg-7 mb-3">
                    <textarea
                        wire:model="sections.{{ $i }}.value"
                        class="form-control"
                        rows="3"
                        placeholder="Value"
                    ></textarea>
                </div>

                <div class="col-lg-2 mb-3 d-flex align-items-start">
                    <button
                        type="button"
                        wire:click="removeSection({{ $i }})"
                        class="btn btn-danger w-100"
                    >
                        Remove
                    </button>
                </div>

            @endforeach
        </div>

        <div class="text-center mb-3">
            <button
                type="button"
                wire:click="addSection"
                class="btn btn-primary"
            >
                + Add Section
            </button>
        </div>

        <div class="row mb-3">
            <div class="col-lg-3">
                <label for="header" class="form-label">Name</label>
            </div>
            <div class="col-lg-9">
                <input wire:model="name" type="text" id="name" class="form-control @error('name') is-invalid @enderror" required>

                @error('name')
                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-lg-3">
                <label for="header" class="form-label">Position</label>
            </div>
            <div class="col-lg-9">
                <input wire:model="position" type="text" id="position" class="form-control @error('position') is-invalid @enderror" required>

                @error('position')
                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-lg-3">
                <label for="header" class="form-label">Note</label>
            </div>
            <div class="col-lg-9">
                <textarea wire:model="note" class="form-control @error('note') is-invalid @enderror" id="note" required
                    rows="4">
                </textarea>

                @error('note')
                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-lg-6">
                <label for="header" class="form-label">Language</label>
                <select wire:model.live="language" class="form-select mb-3" aria-label="Default select example" class="form-control @error('language') is-invalid @enderror" required>
                    <option value="id">Indonesia</option>
                    <option value="en">English</option>
                </select>

                @error('language')
                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-lg-6">
                <label for="currency" class="form-label">Currency</label>
                <select wire:model.live="currency" class="form-select mb-3" aria-label="Default select example" class="form-control @error('currency') is-invalid @enderror" required>
                    <option value="IDR">IDR</option>
                    <option value="USD">USD</option>
                    <option value="EUR">EUR</option>
                    <option value="SGR">SGD</option>
                </select>

                @error('currency')
                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <button class="btn btn-primary w-100 mb-3"
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
    </form>
</div>
