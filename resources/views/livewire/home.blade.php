<div>
    <div class="mt-3">
        <div class="row">
            <div class="col-9">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 text-center">
                                <input type="text" class="form-control form-control-rounded" placeholder="What do you want to ask or share?" type="button" data-bs-toggle="modal" data-bs-target="#askQuestionModal">
                                <div class="row mt-3">
                                    <div class="col-4">
                                        <button class="btn btn-ghost-secondary w-100 btn-pill" type="button" data-bs-toggle="modal" data-bs-target="#askQuestionModal">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-message-question" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M8 9h8"></path>
                                                <path d="M8 13h6"></path>
                                                <path d="M14 18h-1l-5 3v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v4.5"></path>
                                                <path d="M19 22v.01"></path>
                                                <path d="M19 19a2.003 2.003 0 0 0 .914 -3.782a1.98 1.98 0 0 0 -2.414 .483"></path>
                                             </svg>
                                            Ask
                                        </button>
                                    </div>
                                    <div class="col-4">
                                        <a href="{{ route('answer.index') }}" class="btn btn-ghost-secondary w-100 btn-pill">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                                <path d="M16 5l3 3"></path>
                                             </svg>
                                            Answer
                                        </a>
                                    </div>

                                    <div class="col-4">
                                        <button class="btn btn-ghost-secondary w-100 btn-pill">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4"></path>
                                                <path d="M13.5 6.5l4 4"></path>
                                                <path d="M16 19h6"></path>
                                                <path d="M19 16v6"></path>
                                             </svg>
                                            Post
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @php
                    $from = 'home';
                @endphp
                <div class="mb-4">
                    @foreach ($answers as $answer)
                        <livewire:user.answer :$answer wire:key="{{ $answer->id }}" :$from/>
                    @endforeach
                </div>
            </div>
            <div class="col-3">
                <div class="input-icon">
                    <input type="text" class="form-control" placeholder="Search by username…" wire:model.live="search"/>
                    <span class="input-icon-addon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                            <path d="M21 21l-6 -6"></path>
                            </svg>
                    </span>
                </div>
                @if (!empty($search))
                    <div class="mt-3">
                        @if ($users->isEmpty())
                            <div class="text-center text-secondary">
                                User not found
                            </div>
                        @endif
                        @foreach ($users as $user)
                            <div class="mt-2">
                                <div class="card">
                                    <a href="{{ route('profile.index', $user->username_slug) }}">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 text-center">
                                                <span class="text-dark">{{ $user->username }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                <div class="mt-3 mb-3">
                    <button class="btn btn-secondary w-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path>
                            <path d="M9 12h6"></path>
                            <path d="M12 9v6"></path>
                         </svg>
                        Create Space
                    </button>
                </div>
            </div>
        </div>
        <div class="modal" id="askQuestionModal" tabindex="-1" wire:ignore.self>
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form wire:submit="addQuestion">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Question</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <label class="form-label required">Question</label>
                            <input type="text" class="form-control form-control-flush mt-3 @error('title') is-invalid @enderror" wire:model="title" placeholder="Start your question with 'What', 'How', 'Why', etc."/>
                            @error('title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-ghost-secondary btn-pill" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary btn-pill">
                                <div wire:loading wire:target="addQuestion">
                                    <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                </div>
                                Add Question</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
