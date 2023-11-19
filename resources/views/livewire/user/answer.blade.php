<div>
    <div id="{{ $answer->user->username_slug }}" x-data="{open:false}">
        <div class="card mt-3 mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-1">
                        <span class="avatar rounded-circle" style="background-image: url(@if($answer->user->image == null) 'https://ui-avatars.com/api/?name={{ $answer->user->username }}&background=DE6060&color=fff&rounded=true&size=56' @else {{ asset('storage/' . $answer->user->image) }} @endif)"></span>
                    </div>
                    <div class="col-11">
                        <a href="{{ route('profile.index', $answer->user->username_slug) }}" class="text-dark">
                            <b style="font-size: 15px">{{ $answer->user->username }}</b>
                        </a>
                        @if(auth()->id() != $answer->user->id) &#8226;
                            @if(!$followed)
                                <a href="#" style="font-size: 13px" wire:click.prevent="follow"> Follow </a>
                            @else
                                <a href="#" style="font-size: 13px" wire:click.prevent="unfollow" class="text-secondary"> Following </a>
                            @endif
                        @endif
                        <div class="text-secondary" style="font-size: 13px">
                            {{ $credential }}
                            @if($credential) &#8226; @endif  <a href="" class="text-secondary">{{ $answer->created_at->diffForHumans() }}</a>
                        </div>
                    </div>
                </div>
                @if ($from == 'home')
                    <div class="mt-3">
                        <a href="{{ route('question.index', $answer->question->title_slug) }}" class="text-dark"><b style="font-size: 16px">{{ $answer->question->title }}</b></a>
                    </div>
                @endif
                <p class="mt-3" style="font-size: 15px">
                    {{ $answer->answer }}
                </p>
                <div class="mt-3">
                    <small class="text-secondary">{{ $total_views }} views</small>
                </div>
                <div class="mt-2">
                    <button wire:click="votes('up')" class="btn btn-pill btn-outline-secondary @if($vote == 'up') active border-secondary @endif">
                        <div wire:loading.remove wire:target="votes('up')">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-big-up" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M9 20v-8h-3.586a1 1 0 0 1 -.707 -1.707l6.586 -6.586a1 1 0 0 1 1.414 0l6.586 6.586a1 1 0 0 1 -.707 1.707h-3.586v8a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>
                            </svg>
                        </div>
                        <div wire:loading wire:target="votes('up')">
                            <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                        </div>
                        Upvote &#8226; {{ number_format_short($total_upvotes) }}
                    </button>
                    <button wire:click="votes('down')" class="btn btn-pill btn-icon btn-outline-secondary @if($vote == 'down') active border-secondary @endif">
                        <svg wire:loading.remove wire:target="votes('down')" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-big-down" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M15 4v8h3.586a1 1 0 0 1 .707 1.707l-6.586 6.586a1 1 0 0 1 -1.414 0l-6.586 -6.586a1 1 0 0 1 .707 -1.707h3.586v-8a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1z"></path>
                        </svg>
                        <span wire:loading wire:target="votes('down')" class="spinner-border spinner-border-sm" role="status"></span>
                        {{-- Downvote &#8226; {{ $total_downvotes }} --}}

                    </button>
                    {{-- @if ($from == 'home') --}}
                        {{-- <a class="btn btn-pill btn-ghost-secondary" href="{{$answer->question->title_slug . '#' . $answer->user->username_slug}}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-message-circle" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M3 20l1.3 -3.9c-2.324 -3.437 -1.426 -7.872 2.1 -10.374c3.526 -2.501 8.59 -2.296 11.845 .48c3.255 2.777 3.695 7.266 1.029 10.501c-2.666 3.235 -7.615 4.215 -11.574 2.293l-4.7 1"></path>
                            </svg>
                            {{ $total_comments }}
                        </a> --}}
                    {{-- @else

                    @endif --}}
                    <button class="btn btn-pill btn-ghost-secondary" @click="open = ! open">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-message-circle" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M3 20l1.3 -3.9c-2.324 -3.437 -1.426 -7.872 2.1 -10.374c3.526 -2.501 8.59 -2.296 11.845 .48c3.255 2.777 3.695 7.266 1.029 10.501c-2.666 3.235 -7.615 4.215 -11.574 2.293l-4.7 1"></path>
                        </svg>
                        {{ number_format_short($total_comments) }}
                    </button>
                    <button class="btn btn-pill btn-ghost-secondary" data-bs-toggle="modal" data-bs-target="#shareAnswer{{ $answer->id }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-share" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M6 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                            <path d="M18 6m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                            <path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                            <path d="M8.7 10.7l6.6 -3.4"></path>
                            <path d="M8.7 13.3l6.6 3.4"></path>
                        </svg>
                        {{ number_format_short($total_shares) }}
                    </button>
                    <div class="float-end">
                        <svg role="button" data-bs-toggle="dropdown" xmlns="http://www.w3.org/2000/svg" class="mt-2 icon icon-tabler icon-tabler-dots" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M5 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                            <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                            <path d="M19 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        </svg>
                        <div class="dropdown-menu">
                            @if (auth()->id() == $answer->user_id)
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editAnswerModal{{$answer->id}}">
                                    <svg role="button" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                        <path d="M16 5l3 3"></path>
                                    </svg>
                                Edit</a>
                                <a class="dropdown-item" href="#" wire:click.prevent="delete({{ $answer->id }})" wire:confirm="Delete answer?">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M4 7l16 0"></path>
                                        <path d="M10 11l0 6"></path>
                                        <path d="M14 11l0 6"></path>
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                    </svg>
                                Delete</a>
                            @else
                                <a class="dropdown-item" href="#">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="me-2 icon icon-tabler icon-tabler-alert-circle" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path>
                                        <path d="M12 8v4"></path>
                                        <path d="M12 16h.01"></path>
                                    </svg>
                                Report</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div x-show="open">
                    <livewire:user.comments.comment-index :$answer />
                </div>
            </div>
        </div>
    </div>

    @if (auth()->id() == $answer->user_id)
        <div class="modal" id="editAnswerModal{{$answer->id}}" tabindex="-1" wire:ignore.self>
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form wire:submit="edit">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ $answer->question->title }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <label class="form-label required">Answer</label>
                            <input type="text" class="form-control form-control-flush mt-3 @error('answer_edit') is-invalid @enderror" wire:model="answer_edit" placeholder="Write your answer"/>
                            @error('answer_edit')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-ghost-secondary btn-pill" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary btn-pill">
                                <div wire:loading wire:target="edit">
                                    <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                </div>
                                Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <div class="modal" id="shareAnswer{{ $answer->id }}" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title">Share answer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @foreach($shares as $share)
                        <div class="row mb-3">
                            <div class="col-10">
                                {!! $share['svg'] !!}
                                {{ $share['name'] }}
                            </div>
                            <div class="col-2">
                                <a class="btn btn-primary btn-sm btn-pill float-end" href="{{ $share['url'] }}" target="_blank" wire:click="share('{{ $share['name'] }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="me-1 icon icon-tabler icon-tabler-share" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M6 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                        <path d="M18 6m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                        <path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                        <path d="M8.7 10.7l6.6 -3.4"></path>
                                        <path d="M8.7 13.3l6.6 3.4"></path>
                                    </svg>
                                    Share
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
