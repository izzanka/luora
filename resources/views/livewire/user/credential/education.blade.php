<div>
    <div class="modal" id="educationModal" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <form wire:submit="update">
                    <div class="modal-header">
                        <b>Edit credentials</b>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-header">
                                <svg xmlns="http://www.w3.org/2000/svg" class="me-2 icon icon-tabler icon-tabler-school" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M22 9l-10 -4l-10 4l10 4l10 -4v6"></path>
                                    <path d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4"></path>
                                </svg>
                                Add education credential
                            </div>
                            <div class="card-body">
                                <label class="form-label required">School</label>
                                <input type="text" class="form-control @error('school') is-invalid @enderror" wire:model.blur="school" />
                                @error('school')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <label class="form-label required mt-3">Major</label>
                                <input type="text" class="form-control @error('major') is-invalid @enderror" wire:model.blur="major" />
                                @error('major')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <label class="form-label required mt-3">Degree Type</label>
                                <input type="text" class="form-control @error('degree_type') is-invalid @enderror" wire:model.blur="degree_type" />
                                @error('degree_type')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <label class="form-label required mt-3">Graduation Year</label>
                                <input type="number" class="form-control @error('graduation_year') is-invalid @enderror" wire:model.blur="graduation_year" />
                                @error('graduation_year')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                                @if (auth()->user()->education()->exists())
                                    <div class="d-grid mt-3">
                                        <button class="btn btn-ghost-danger" type="button" wire:click="delete" wire:confirm="Delete education credential?">
                                            <div wire:loading.remove wire:target="delete">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M4 7l16 0"></path>
                                                    <path d="M10 11l0 6"></path>
                                                    <path d="M14 11l0 6"></path>
                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                                </svg>
                                            </div>
                                            <div wire:loading wire:target="delete">
                                                <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                            </div>
                                            Delete
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-ghost-secondary btn-pill" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-pill">
                            <div wire:loading wire:target="update">
                                <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                            </div>
                        Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
