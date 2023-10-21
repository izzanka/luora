<div>
    <div class="card mt-2">
        <div class="card-body">
            <a href="{{ route('question.index', $question->title_slug) }}" class="text-dark" target="_blank">
                <b style="font-size: 16px">{{ $question->title }}</b>
            </a>
            <div class="mt-2 text-secondary">
                <a href="{{ route('question.index', $question->title_slug) }}" class="text-secondary" style="font-size: 13px">
                    <b>
                    @if ($question->answers()->count() > 0)
                        {{ $question->answers()->count() }} answers
                    @else
                        No answer yet
                    @endif
                    </b>
                </a>
                &#8226;
                <span style="font-size: 13px">
                    Last updated {{ $question->updated_at ? $question->updated_at->diffForHumans() : $question->created_at->diffForHumans() }}
                </span>
            </div>
            <div class="mt-3">
                <button @if($already_answer != 0) disabled @endif class="btn btn-pill btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#answerQuestionModal{{ $question->id }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                        <path d="M16 5l3 3"></path>
                    </svg>
                    Answer
                </button>
            </div>
        </div>
    </div>
    <div class="modal" id="answerQuestionModal{{ $question->id }}" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <form wire:submit="answerQuestion">
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
</div>
