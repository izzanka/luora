<div id="{{ $answer_id }}">
    @foreach ($comments as $comment)
    <hr>
    <div class="row mt-2">
        <div class="col-1">
            <img src="{{ $comment->user->avatar }}" alt="avatar" class="rounded-circle" width="42px" height="42px">
        </div>
        <div class="col-11">
            <a href="{{ route('profile.show',$comment->user->name_slug) }}" class="text-dark"><b>{{ $comment->user->name }}</b></a>
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
                <div class="col-6 dropup">
                    <a class="text-dark float-right dropdown-toogle" id="editComment" href="" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre><i class="bi bi-three-dots"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="editComment">
                        @if ($comment->user->id == auth()->id())
                            <a href="" data-attr="{{ route('comment.update',$comment->id) }}" data-text="{{ $comment->comment }}" class="dropdown-item" data-toggle="modal" data-target="#update_commentModal" id="updateComment">
                                Edit comment
                            </a>
                            
                            <a href="{{ route('comment.destroy',$comment->id) }}" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this comment?')">
                                Delete comment
                            </a>
                        @else
                            @if ($reported_comment)
                                <a class="dropdown-item text-danger">
                                    Reported
                                </a>
                            @else
                                <a href="" data-attr="{{ route('comment.report',$comment->id) }}" class="dropdown-item" data-toggle="modal" data-target="#report_commentModal" id="reportComment">
                                    Report
                                </a>
                            @endif
                 
                        @endif
                    </div>
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
