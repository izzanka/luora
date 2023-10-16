<div>
    <div class="row">
        <div class="col-8">
            <div class="card mt-3">
                <div class="card-body">
                    <b style="font-size: 21px">{{ $question->title }}</b>
                    <div class="mt-3">
                        @if (auth()->id() != $question->user_id)
                            <button @if($already_answer > 0) disabled @endif class="btn btn-pill btn-outline-secondary"  @if($already_answer == 0) data-bs-toggle="modal" data-bs-target="#answerQuestionModal" @endif>
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                    <path d="M16 5l3 3"></path>
                                </svg>
                                Answer
                            </button>
                            <div class="float-end">
                                <svg role="button" data-bs-toggle="dropdown" xmlns="http://www.w3.org/2000/svg" class="mt-2 icon icon-tabler icon-tabler-dots" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M5 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                    <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                    <path d="M19 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                </svg>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="me-2 icon icon-tabler icon-tabler-alert-circle" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path>
                                            <path d="M12 8v4"></path>
                                            <path d="M12 16h.01"></path>
                                        </svg>
                                    Report</a>
                                </div>
                            </div>
                        @else
                        <div class="float-end">
                            <svg role="button" data-bs-toggle="dropdown" xmlns="http://www.w3.org/2000/svg" class="mt-2 icon icon-tabler icon-tabler-dots" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M5 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                <path d="M19 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                            </svg>
                            <div class="dropdown-menu">
                                @if (auth()->id() == $question->user_id)
                                    <a class="dropdown-item" href="#" wire:click.prevent="delete({{ $question->id }})" wire:confirm="Delete question?">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M4 7l16 0"></path>
                                            <path d="M10 11l0 6"></path>
                                            <path d="M14 11l0 6"></path>
                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                        </svg>
                                    Delete</a>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @if (!$answers->isEmpty())
                <div class="mt-3">
                    <div class="text-end">
                        Sort
                        <button class="btn ms-2 btn-pill dropdown-toggle" data-bs-toggle="dropdown">
                            @if ($sort_by == 'Recent')
                                <svg xmlns="http://www.w3.org/2000/svg" class="me-2 icon icon-tabler icon-tabler-clock-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M21 12a9 9 0 1 0 -9.972 8.948c.32 .034 .644 .052 .972 .052"></path>
                                    <path d="M12 7v5l2 2"></path>
                                    <path d="M18.42 15.61a2.1 2.1 0 0 1 2.97 2.97l-3.39 3.42h-3v-3l3.42 -3.39z"></path>
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="me-2 icon icon-tabler icon-tabler-arrow-big-up" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M9 20v-8h-3.586a1 1 0 0 1 -.707 -1.707l6.586 -6.586a1 1 0 0 1 1.414 0l6.586 6.586a1 1 0 0 1 -.707 1.707h-3.586v8a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>
                                </svg>
                            @endif
                            {{ $sort_by }}
                        </button>
                        <div class="dropdown-menu">
                            <a href="#" class="dropdown-item" wire:click.prevent="sort">
                                @if ($sort_by != 'Recent')
                                <svg xmlns="http://www.w3.org/2000/svg" class="me-2 icon icon-tabler icon-tabler-clock-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M21 12a9 9 0 1 0 -9.972 8.948c.32 .034 .644 .052 .972 .052"></path>
                                    <path d="M12 7v5l2 2"></path>
                                    <path d="M18.42 15.61a2.1 2.1 0 0 1 2.97 2.97l-3.39 3.42h-3v-3l3.42 -3.39z"></path>
                                </svg>
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="me-2 icon icon-tabler icon-tabler-arrow-big-up" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M9 20v-8h-3.586a1 1 0 0 1 -.707 -1.707l6.586 -6.586a1 1 0 0 1 1.414 0l6.586 6.586a1 1 0 0 1 -.707 1.707h-3.586v8a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>
                                </svg>
                                @endif
                                {{ $sort_by == 'Recent' ? 'Upvote' : 'Recent' }}
                            </a>
                        </div>
                    </div>
                </div>
                @foreach ($answers as $answer)
                    <livewire:user.answer :$answer :key="$answer->id"/>
                @endforeach
                @if($total_answers > 5)
                    <div class="text-center mt-3 mb-3">
                        <button class="btn btn-secondary btn-pill" wire:click="loadMore" @if($total_answers >= $limitPerPage) @else disabled @endif>
                            <div wire:loading.remove wire:target="loadMore">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-reload" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M19.933 13.041a8 8 0 1 1 -9.925 -8.788c3.899 -1 7.935 1.007 9.425 4.747"></path>
                                    <path d="M20 4v5h-5"></path>
                                </svg>
                            </div>
                            <div wire:loading wire:target="loadMore">
                                <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                            </div>
                            Load More
                        </button>
                    </div>
                @endif
            @endif

        </div>
        @if($already_answer == 0)
        <div class="modal" id="answerQuestionModal" tabindex="-1" wire:ignore.self>
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form wire:submit="answerQuestion({{ $question->id }})">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ $question->title }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <label class="form-label required">Answer</label>
                            <input type="text" class="form-control form-control-flush mt-3 @error('answer') is-invalid @enderror" wire:model="answer" placeholder="Write your answer"/>
                            @error('answer')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-ghost-secondary btn-pill" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary btn-pill">
                                <div wire:loading wire:target="answerQuestion">
                                    <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                </div>
                                Post
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
        <div class="col-4 mt-3">
            <div class="card">
                <div class="card-header" style="font-size: 15px">
                    Other Questions
                </div>
                <div class="card-body">
                    @foreach ($questions as $question)
                        <div class="mb-3" wire:key="{{ $question->id }}">
                            <a style="font-size: 15px" href="{{ route('question.index', $question->title_slug) }}">{{ $question->title }}</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</div>
