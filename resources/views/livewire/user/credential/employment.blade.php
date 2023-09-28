<div>
    <div class="modal" id="employmentModal" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <form wire:submit="addEmployment">
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
                                <label class="form-label">Position</label>
                                <input type="text" class="form-control @error('position') is-invalid @enderror" wire:model.blur="position" />
                                @error('position')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <label class="form-label mt-3">Company</label>
                                <input type="text" class="form-control @error('company') is-invalid @enderror" wire:model.blur="company"/>
                                @error('company')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <label class="form-label mt-3">Start Year</label>
                                <select wire:model.blur="employment_start_year" id="employment-start-year" class="form-select">
                                    @if ($employment_start_year != null)
                                        <option value="{{ $employment_start_year }}" selected>{{ $employment_start_year }}</option>
                                        <option value="" disabled>----</option>
                                    @endif
                                </select>
                                @error('employment_start_year')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <label class="form-label mt-3">End Year</label>
                                <select wire:model.blur="employment_end_year" id="employment-end-year" class="form-select">
                                    @if ($employment_end_year != null)
                                        <option value="{{ $employment_end_year }}" selected>{{ $employment_end_year }}</option>
                                        <option value="" disabled>----</option>
                                    @endif
                                </select>
                                @error('employment_end_year')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <label class="form-check mt-3">
                                    <input type="checkbox" class="form-check-input" wire:model.blur="employment_currently"/>
                                    <span class="form-check-label">I currently work here</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-ghost-secondary btn-pill" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-pill">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
