<div>
    {{-- <div class="flex items-start gap-4 justify-start mt-4">
        <div class="overflow-hidden rounded-full w-8 h-8">
        </div>
        <div class="flex-1">
            <div class="">
                <div>
                    <div class="flex items-center justify-start gap-1">
                        <h3 class="font-semibold">{{ $comment->user->name }}</h3>
                        <span>-</span>
                        <p class="text-xs">{{ $comment->created_at->diffForHumans() }}</p>
                    </div>
                    @if($editing)
                        <livewire:user.comments.comment-create
                            wire:key="'edit-'.$comment->id"
                            :answer-id="$comment->answer_id"
                            :comment-model="$comment"
                            :show-profile="false" />
                    @else
                        <p class="text-sm">
                            {{ $comment->comment }}
                        </p>
                    @endif
                    <div class="flex items-center justify-start gap-4">
                        <p wire:click.prevent="startReplying" class="flex items-center uppercase text-[10px] cursor-pointer font-semibold transition-all duration-300 ease-in-out hover:underline">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-[13px] h-[13px]">
                                <path fill-rule="evenodd" d="M2 10c0-3.967 3.69-7 8-7 4.31 0 8 3.033 8 7s-3.69 7-8 7a9.165 9.165 0 01-1.504-.123 5.976 5.976 0 01-3.935 1.107.75.75 0 01-.584-1.143 3.478 3.478 0 00.522-1.756C2.979 13.825 2 12.025 2 10z" clip-rule="evenodd" />
                            </svg>
                            <span class="ml-1">Reply</span>
                        </p>

                        @if(auth()->check() && auth()->id() == $comment->user_id)
                            <p wire:click.prevent="startCommentEdit" class="flex items-center uppercase text-[10px] cursor-pointer font-semibold transition-all duration-300 ease-in-out hover:underline">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-[13px] h-[13px]">
                                    <path d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                                    <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                                </svg>

                                <span class="ml-1">Edit</span>
                            </p>

                            <p wire:click.prevent="deleteComment" class="flex items-center uppercase text-[10px] cursor-pointer font-semibold transition-all duration-300 ease-in-out hover:underline">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-[13px] h-[13px]">
                                    <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" />
                                </svg>

                                <span class="ml-1">Delete</span>
                            </p>
                        @endif
                    </div>
                </div>

                @if($comment->replies)
                    @foreach($comment->replies as $reply)
                        <livewire:user.comments.comment-item wire:key="{{ $reply->id }}" :comment="$reply" />
                    @endforeach
                @endif
            </div>

            @if($replying)
                <livewire:user.comments.comment-create
                    wire:key="'reply-'.$comment->id"
                    :answer-id="$comment->answer_id"
                    :parent-id="$comment->id"
                    :show-profile="false" />
            @endif
        </div>
    </div> --}}
    @php
        $from = request()->route()->named('home') ? 'home' : $comment->answer->question->title_slug;
    @endphp
    <hr class="mt-3 mb-2">
    <div class="row">
        <div class="col-1">
            <span class="avatar rounded-circle avatar-sm" style="background-image: url(@if($comment->user->image == null) 'https://ui-avatars.com/api/?name={{ $comment->user->username }}&background=DE6060&color=fff&rounded=true&size=56' @else {{ asset('storage/' . $comment->user->image) }} @endif)"></span>
        </div>
        <div class="col-11">
            <div style="font-size: 13px">
                <b>{{ $comment->user->username }}</b> &#8226; {{ $comment->created_at->diffForHumans() }}
            </div>
            <div class="mt-1">
                @if($editing)
                    <div class="mt-3">
                        <livewire:user.comments.comment-create
                            wire:key="'edit-'.$comment->id"
                            :parent-id="null"
                            :answer-id="$comment->answer_id"
                            :comment-model="$comment"
                            :show-profile="false"
                            :is-editing="true" />
                    </div>
                @else
                    <p style="font-size: 15px">
                        {{ $comment->comment }}
                    </p>
                @endif
            </div>
            @if(!$editing)
                <div>
                    {{-- <button wire:click="votes('up','{{ $from }}')" class="btn btn-pill btn-icon btn-outline-secondary @if($vote == 'up') active border-secondary @endif">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-big-up" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M9 20v-8h-3.586a1 1 0 0 1 -.707 -1.707l6.586 -6.586a1 1 0 0 1 1.414 0l6.586 6.586a1 1 0 0 1 -.707 1.707h-3.586v8a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>
                        </svg>
                    </button>
                    <button wire:click="votes('down','{{ $from }}')" class="btn btn-pill btn-icon btn-outline-secondary @if($vote == 'down') active border-secondary @endif">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-big-down" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M15 4v8h3.586a1 1 0 0 1 .707 1.707l-6.586 6.586a1 1 0 0 1 -1.414 0l-6.586 -6.586a1 1 0 0 1 .707 -1.707h3.586v-8a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1z"></path>
                        </svg>
                    </button> --}}
                    <button class="btn btn-ghost-secondary btn-pill" wire:click="startReplying">
                        <div wire:loading wire:target="startReplying">
                            <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                        </div>
                        Reply
                    </button>
                    <div class="float-end">
                        <svg role="button" data-bs-toggle="dropdown" xmlns="http://www.w3.org/2000/svg" class="mt-2 icon icon-tabler icon-tabler-dots" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M5 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                            <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                            <path d="M19 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        </svg>
                        <div class="dropdown-menu">
                            @if (auth()->id() == $comment->user->id)
                                <a class="dropdown-item" href="#" wire:click.prevent="startEditing">
                                    <svg role="button" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                        <path d="M16 5l3 3"></path>
                                    </svg>
                                Edit</a>

                                <a class="dropdown-item" href="#" wire:click.prevent="deleteComment('{{ $from }}')" wire:confirm="Delete comment?">
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
            @endif
            @if($comment->replies)
            <div class="mt-2">
                @foreach($comment->replies as $reply)
                    <livewire:user.comments.comment-item wire:key="{{ $reply->id }}" :comment="$reply" />
                @endforeach
            </div>
            @endif
        </div>
        @if($replying)
            <div class="mt-2 mb-2">
                <livewire:user.comments.comment-create
                    wire:key="'reply-'.$comment->id"
                    :comment_model="null"
                    :answer-id="$comment->answer_id"
                    :parent-id="$comment->id"
                    :show-profile="false"
                    :is-editing="false" />
            </div>
        @endif
    </div>
    {{-- <hr class="mt-2 mb-2"> --}}
</div>
