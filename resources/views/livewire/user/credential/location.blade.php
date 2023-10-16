<div>
    <div class="modal" id="locationModal" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <form wire:submit="update">
                    <div class="modal-header">
                        <b>Edit credentials</b>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-header">
                                <svg xmlns="http://www.w3.org/2000/svg" class="me-2 icon icon-tabler icon-tabler-map-pin" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                                    <path d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z"></path>
                                </svg>
                                Add location credential
                            </div>
                            <div class="card-body">
                                <label class="form-label required">Location</label>
                                <input type="text" class="form-control @error('location') is-invalid @enderror" wire:model.blur="location"/>
                                @error('location')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <label class="form-label required mt-3">Start Year</label>
                                <input type="text" class="form-control @error('start_year') is-invalid @enderror" wire:model.blur="start_year"/>
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
                                    <span class="form-check-label">I currently live here</span>
                                </label>

                                @if (auth()->user()->location()->exists())
                                    <div class="d-grid mt-3">
                                        <button class="btn btn-ghost-danger" type="button" wire:click="delete" wire:confirm="Delete location credential?">
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
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
