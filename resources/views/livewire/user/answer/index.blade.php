<div>
    <div class="row mt-3">
        <div class="col-9">
            <div class="card">
                <div class="card-body">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="me-1 icon icon-tabler icon-tabler-star-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z" stroke-width="0" fill="currentColor"></path>
                        </svg>
                        Questions for you
                    </div>
                </div>
            </div>
            @foreach ($questions as $question)
            <div class="card mt-3">
                <div class="card-body">
                    <a href="" class="text-dark">
                        <b>{{ $question->title }}</b>
                    </a>
                    <div class="mt-2 text-secondary">
                        <a href="" class="text-secondary">{{ $question->answers()->count() }} answers</a> &#8226; Last updated {{ $question->created_at->diffForHumans() }}
                    </div>
                    <div class="mt-3">
                        <button class="btn btn-pill btn-outline-secondary" >
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
            @endforeach
        </div>
        <div class="col-3">
        </div>
    </div>
</div>
