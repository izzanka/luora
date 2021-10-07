<div id="{{ $answer_id }}">
    @foreach ($comments as $comment)
    <hr>
    <div class="row mt-2">
        <div class="col-1">
            <img src="{{ $comment->user->avatar }}" alt="avatar" class="rounded-circle" width="42px" height="42px">
        </div>
        <div class="col-11">
            <b>{{ $comment->user->name }}</b>
            <div class="text-secondary mb-2">
                {{ $comment->created_at->format('M d, Y')  }}
            </div>
            {{ $comment->comment }}
            <div class="row mt-2">
                <div class="col-6">
                    <span>
                        <a href="javascript: void(0)" class="text-dark" id="reply"><i class="bi bi-reply"></i> Reply</a>
                    </span>
                </div>
                <div class="col-6">
                    <i class="bi bi-three-dots float-right"></i>
                </div>
            </div>
           
        </div>
    </div>
    {{-- <div id="show_reply">
        <div class="row ml-5 mt-2">
            <div class="col-10">
                <input type="text" class="form-control">
            </div>
            <div class="col-2">
                <button class="btn btn-primary">Reply</button>
            </div>
        </div>
    </div> --}}
    @endforeach
</div>
