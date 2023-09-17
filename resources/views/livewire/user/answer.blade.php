<div>
    <div class="card mt-3">
        <div class="card-body">
            <div>
                <div class="row">
                    <span class="avatar rounded-circle ms-2" style="background-image: url(@if($answer->user->image == null) 'https://ui-avatars.com/api/?name={{ $answer->user->username }}&background=DE6060&color=fff&rounded=true&size=56' @else {{ asset($answer->user->image) }} @endif)"></span>
                    <div class="col-11">
                        <a href="" class="text-dark"><b>{{ $answer->user->username }}</b></a> &#8226;
                        <a href="">Follow</a>
                        <div class="text-secondary">
                            {{ $answer->user->credential ?? 'web developer' }} &#8226; <a href="" class="text-secondary">{{ $answer->created_at->diffForHumans() }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <a href="" class="text-dark"><b>{{ $answer->question->title }}</b></a>
            </div>
            <p class="mt-2">{{ $answer->answer }}</p>
            <div class="mt-3">
                <small class="text-secondary">{{ $answer->total_views }} views</small>
            </div>
            <div class="mt-2">
                <button wire:click="votes('up')" class="btn btn-pill btn-outline-secondary" >
                    @if ($vote == 'up')
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-big-up-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M10.586 3l-6.586 6.586a2 2 0 0 0 -.434 2.18l.068 .145a2 2 0 0 0 1.78 1.089h2.586v7a2 2 0 0 0 2 2h4l.15 -.005a2 2 0 0 0 1.85 -1.995l-.001 -7h2.587a2 2 0 0 0 1.414 -3.414l-6.586 -6.586a2 2 0 0 0 -2.828 0z" stroke-width="0" fill="currentColor"></path>
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-big-up" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M9 20v-8h-3.586a1 1 0 0 1 -.707 -1.707l6.586 -6.586a1 1 0 0 1 1.414 0l6.586 6.586a1 1 0 0 1 -.707 1.707h-3.586v8a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>
                        </svg>
                    @endif
                    Upvote &#8226; {{ $total_upvotes }}
                </button>
                <button wire:click="votes('down')" class="btn btn-pill btn-outline-secondary" >
                    @if ($vote == 'down')
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-big-down-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M10 2l-.15 .005a2 2 0 0 0 -1.85 1.995v6.999l-2.586 .001a2 2 0 0 0 -1.414 3.414l6.586 6.586a2 2 0 0 0 2.828 0l6.586 -6.586a2 2 0 0 0 .434 -2.18l-.068 -.145a2 2 0 0 0 -1.78 -1.089l-2.586 -.001v-6.999a2 2 0 0 0 -2 -2h-4z" stroke-width="0" fill="currentColor"></path>
                        </svg>
                    @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-big-down" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M15 4v8h3.586a1 1 0 0 1 .707 1.707l-6.586 6.586a1 1 0 0 1 -1.414 0l-6.586 -6.586a1 1 0 0 1 .707 -1.707h3.586v-8a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1z"></path>
                     </svg>
                    @endif
                    Downvote &#8226; {{ $total_downvotes }}
                </button>
                <button class="btn btn-pill btn-ghost-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-message-circle" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M3 20l1.3 -3.9c-2.324 -3.437 -1.426 -7.872 2.1 -10.374c3.526 -2.501 8.59 -2.296 11.845 .48c3.255 2.777 3.695 7.266 1.029 10.501c-2.666 3.235 -7.615 4.215 -11.574 2.293l-4.7 1"></path>
                    </svg>
                    0
                </button>
                <button class="btn btn-pill btn-ghost-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-share" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M6 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                        <path d="M18 6m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                        <path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                        <path d="M8.7 10.7l6.6 -3.4"></path>
                        <path d="M8.7 13.3l6.6 3.4"></path>
                    </svg>
                    0
                </button>
            </div>
        </div>
    </div>
</div>
