<div>
    <div class="row mt-3">
        <div class="col-9">
            <div class="card">
                <div class="card-body">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="me-1 text-danger icon icon-tabler icon-tabler-star-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z" stroke-width="0" fill="currentColor"></path>
                        </svg>
                        Questions for you
                    </div>
                </div>
            </div>

            <div class="mb-3">
                @foreach ($questions as $question)
                    <livewire:user.question.question-show :$question :key="$question->id"/>
                @endforeach
            </div>

            @if(!$questions->isEmpty())
                <div class="text-center mt-3 mb-3">
                    <button class="btn btn-secondary btn-pill" wire:click="loadMore" @if($total_questions >= $limitPerPage) @else disabled @endif>
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
            @else
                <div class="text-center mt-3">
                    No questions
                </div>
            @endif

        </div>
        <div class="col-3 mt-1">
            Topics you know about
            <span class="float-end">
                <svg data-bs-toggle="modal" data-bs-target="#topicModal" role="button" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                    <path d="M16 5l3 3"></path>
                </svg>
            </span>
            <hr class="mt-3 mb-3">
            @if($followed_topics->isEmpty())
                <div class="card">
                    <div class="card-body text-center">
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
                        <p class="mt-2">
                            You'll get better questions if you add more spesific topics.
                        </p>
                        <button class="btn btn-outline-primary btn-pill" data-bs-toggle="modal" data-bs-target="#topicModal">
                            Add topics
                        </button>
                    </div>
                </div>
            @else
                @foreach ($followed_topics as $topic)
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-1">
                                <span class="avatar avatar-sm rounded-circle" style="background-image: url('https://ui-avatars.com/api/?name={{ $topic->name }}&background=DE6060&color=fff&rounded=true&size=112')"></span>
                            </div>
                            <div class="col-11 mt-1">
                                <a href="#" class="text-dark ms-3">{{ $topic->name }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
            <livewire:user.topic.topic-index/>
        </div>
    </div>

</div>
