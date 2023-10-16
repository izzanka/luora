<div>
    <div class="modal" id="employmentModal" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <form wire:submit="addEmploymentCredential">
                    <div class="modal-header">
                        <b>Edit credentials</b>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-header">
                                <svg xmlns="http://www.w3.org/2000/svg" class="me-2 icon icon-tabler icon-tabler-briefcase" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M3 7m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z"></path>
                                    <path d="M8 7v-2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v2"></path>
                                    <path d="M12 12l0 .01"></path>
                                    <path d="M3 13a20 20 0 0 0 18 0"></path>
                                </svg>
                                Add employment credential
                            </div>
                            <div class="card-body">
                                <label class="form-label required">Position</label>
                                <input type="text" class="form-control @error('position') is-invalid @enderror" wire:model.blur="position" />
                                @error('position')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <label class="form-label required mt-3">Company</label>
                                <input type="text" class="form-control @error('company') is-invalid @enderror" wire:model.blur="company"/>
                                @error('company')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <label class="form-label required mt-3">Start Year</label>
                                <input type="number" class="form-control @error('start_year') is-invalid @enderror" wire:model.blur="start_year">
                                @error('start_year')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                                @if(!$currently)
                                    <label class="form-label required mt-3">End Year</label>
                                    <input type="number" class="form-control @error('end_year') is-invalid @enderror" wire:model.blur="end_year">
                                    @error('end_year')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                @endif

                                <label class="form-check mt-3">
                                    <input type="checkbox" class="form-check-input" wire:model.live="currently" onclick="this.blur();"/>
                                    <span class="form-check-label">I currently work here</span>
                                </label>

                                @if (auth()->user()->employment()->exists())
                                    <div class="d-grid mt-3">
                                        <button class="btn btn-ghost-danger" type="button" wire:click="delete" wire:confirm="Delete employment credential?">
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
                            <div wire:loading wire:target="addEmploymentCredential">
                                <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                            </div>
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
