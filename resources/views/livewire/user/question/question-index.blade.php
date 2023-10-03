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
                        @endif
                    </div>
                </div>
            </div>
            @if (!$answers->isEmpty())
                <div class="mt-3">
                    <div class="text-end">
                        Sort
                        <button class="btn ms-2 btn-pill dropdown-toggle" data-bs-toggle="dropdown">{{ $sort_by }}</button>
                        <div class="dropdown-menu">
                            <a href="#" class="dropdown-item" wire:click.prevent="sort"> {{ $sort_by == 'Recent' ? 'Upvote' : 'Recent' }}</a>
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
                            <label class="form-label">Answer</label>
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
