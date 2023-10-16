<div>
    <div class="modal" id="topicModal" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <b>Topics you know about</b>
                </div>
                <div class="modal-body">
                    Topics are how Luora knows what questions to send your way. Be as comprehensive and specific as possible to get the most relevant questions.
                    <div class="input-icon mt-3">
                        <input type="text" class="form-control" placeholder="Add topic" wire:model.live="search"/>
                        <span class="input-icon-addon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                <path d="M21 21l-6 -6"></path>
                            </svg>
                        </span>
                    </div>
                    <div class="mt-3">
                        @if (!empty($search))
                            <div class="mt-3">
                                @if ($topics->isEmpty())
                                    <div class="text-center text-secondary">
                                        Topic not found
                                    </div>
                                @endif
                                <div class="row">
                                    @foreach ($topics as $topic)
                                    <div class="col-4 mb-2">
                                        <button class="btn btn-outline-secondary w-full" wire:click="follow('{{ $topic->id }}')">
                                            {{ $topic->name }}
                                            <br><br>
                                            {{ $topic->total_followers }} followers
                                        </button>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            @if ($followed_topics->isEmpty())
                                <div class="text-center">
                                    <div class="mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mailbox" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M10 21v-6.5a3.5 3.5 0 0 0 -7 0v6.5h18v-6a4 4 0 0 0 -4 -4h-10.5"></path>
                                            <path d="M12 11v-8h4l2 2l-2 2h-4"></path>
                                            <path d="M6 15h1"></path>
                                        </svg>
                                    </div>
                                    <b class="text-secondary">
                                        No topics yet
                                    </b>
                                </div>
                            @else
                                @foreach ($followed_topics as $topic)
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-1">
                                                <span class="avatar avatar-sm rounded-circle" style="background-image: url('https://ui-avatars.com/api/?name={{ $topic->name }}&background=DE6060&color=fff&rounded=true&size=112')"></span>
                                            </div>
                                            <div class="col-9 mt-1">
                                                {{ $topic->name }}
                                            </div>
                                            <div class="col-1 mt-1">
                                                <button class="btn btn-pill btn-sm btn-danger" wire:click="unfollow('{{ $topic->id }}')">
                                                    Unfollow
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        @endif
                    </div>
                </div>
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-ghost-secondary btn-pill" data-bs-dismiss="modal">Cancel</button>
                </div> --}}
            </div>
        </div>
    </div>
</div>
