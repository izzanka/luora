@extends('layouts.app')

@section('title')
{{ $question->title }}
@endsection

@section('content')
@include('layouts.answer')

<!-- Report Answer Modal -->
@include('layouts.report-answer')

{{-- Report Comment Modal --}}
<form action="" method="POST" id="report-commentForm">
    @csrf
    <div class="modal fade" id="report_commentModal" aria-labelledby="report_commentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="report_commentModalLabel">Report comment</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="form-check">
                    @foreach ($report_comment_types as $report_comment_type)
                        <input class="form-check-input" type="radio" name="type" id="{{ $report_comment_type['name'] }}" value="{{ $report_comment_type['name'] }}">
                        <label class="form-check-label" for="{{ $report_comment_type['name'] }}">
                            <b>{{ $report_comment_type['name'] }}</b><br>
                            <span class="text-secondary">{{ $report_comment_type['desc'] }}</span>
                        </label>
                        <br><br>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-text rounded-pill" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary rounded-pill" id="store-reportComment">Submit</button>
            </div>
        </div>
        </div>
    </div>
</form>

<!-- Edit Comment -->
<form action="" method="POST" id="comment-updateForm">
    @csrf
    @method('PUT')
    <div class="modal fade" id="update_commentModal" aria-labelledby="update_commentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="update_commentModalLabel"><b>Edit Comment</b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <textarea type="text" name="comment" class="form-control" autocomplete="off" id="textComment"></textarea>
                        @include('layouts.error', ['name' => 'comment'])
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-text rounded-pill" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary rounded-pill update-comment">Update</button>
            </div>
        </div>
        </div>
    </div>
</form>

<!-- Report Question Modal -->
@include('layouts.report-question')

<!-- Modal Question-->
<form action="{{ route('question.update',$question->title_slug) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="modal fade" id="questionModal" aria-labelledby="questionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="questionModalLabel"><b>Edit Question</b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <input type="text" name="title" value="{{ $question->title }}" class="form-control" autocomplete="off">
                        @include('layouts.error', ['name' => 'title'])
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-text rounded-pill" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary rounded-pill">Update</button>
            </div>
        </div>
        </div>
    </div>
</form>

<!-- Modal Topic-->
<form action="{{ route('question.update',$question->title_slug) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="modal fade" id="topicModal" aria-labelledby="topicModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="topicModalLabel">Edit Topic</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                Topics : 
                <div class="row mt-2">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    @foreach ($topics as $topic)
                                    <div class="col-sm-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{ $topic->id }}" id="{{ $topic->id }}" name="topic_id[]"
                                            @php
                                                $checked = "";
                                                foreach($question->topics as $qtopic){
                                                    if($qtopic->name == $topic->name){
                                                        $checked = "checked";
                                                    }
                                                }
                                            @endphp 
                                            {{ $checked }}>
                                            <label class="form-check-label" for="{{ $topic->id }}">
                                            {{ $topic->name }}
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>     
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-light rounded-pill" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary rounded-pill">Update</button>
            </div>
        </div>
        </div>
    </div>
</form>

<div class="container">
    <div class="row">
        <div class="col-8">
            <div class="row">
                <div class="col-12">
                    @include('layouts.success')
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        @foreach ($question->topics as $topic)
                                            <div class="col-3 mt-2">
                                                <div class="card">
                                                    <a href="{{ route('topic.show',$topic->name_slug) }}" class="text-secondary text-center">{{ $topic->name }}</a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h4><b>{{ $question->title }}</b></h4>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">

                                    @if ($question->user_id != auth()->id())
                                        @if ($answered == null)
                                            <a href="" data-toggle="modal" data-target="#answerModal" data-attr="{{ route('answer.store',$question->title_slug) }}" id="answer"><i class="bi bi-pencil-square"></i> Answer</a>            
                                        @endif
                                    @endif
                                
                                    <a class="text-dark float-right dropdown-toogle" id="navbarDropdown" href="" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre><i class="bi bi-three-dots"></i></a>
                                    <br>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        @if ($question->user_id == auth()->id())
                                        <a href="" class="dropdown-item" data-toggle="modal" data-target="#questionModal">
                                            Edit question
                                        </a>
                                        <a href="" class="dropdown-item" data-toggle="modal" data-target="#topicModal">
                                            @if (count($question->topics))
                                                Edit topics
                                            @else
                                                Add topics
                                            @endif
                                        </a>

                                        <a href="{{ route('question.destroy',$question->title_slug) }}" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this question?')">
                                            Delete question
                                        </a>
                                        @else
                                            
                                            @if ($reported_question)
                                                <a class="dropdown-item text-danger">
                                                    Reported
                                                </a>
                                            @else
                                                <a href="" class="dropdown-item text-dark" data-toggle="modal" data-target="#report_questionModal">
                                                    Report
                                                </a>
                                            @endif
                                            
                                            <a class="dropdown-item">
                                                Bookmark
                                            </a>

                                            <a class="dropdown-item">
                                                Hide
                                            </a>
                                        @endif
                                       
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-12">
                                            {{ $question->answers->count() }} Answers
                                        </div>
                                    </div>
                                </div>
                            </div>
                          
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    @foreach ($answers as $answer)
                        <!-- Modal Answer-->
                        <form action="" method="POST" id="answer-updateForm">
                            @csrf
                            @method('PUT')
                            <div class="modal fade" id="answer-updateModal" aria-labelledby="answer-updateModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="answer-updateModalLabel"><b>Edit Answer</b></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <textarea name="text" class="form-control" id="textAnswer" autocomplete="off"></textarea>
                                                @include('layouts.error', ['name' => 'text'])
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-light rounded-pill" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary answer-update rounded-pill">Update</button>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </form>

                        @php
                        $credential = \App\Http\Controllers\User\ProfileController::set_credential($answer->user);
                        @endphp

                        <div id="{{ $answer->user->name_slug }}">
                        <div class="card mt-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <img src="{{$answer->user->avatar}}" alt="avatar" class="rounded-circle" width="45px" height="45px">
                                            </div>
                                            
                                            <div class="col-sm-11">
                                                <b><a href="{{ route('profile.show',$answer->user->name_slug) }}" class="text-dark">{{ $answer->user->name  }}</a></b> &#183;
                                                @php
                                                    //set follow status
                                                    if(auth()->user()->isFollowing($answer->user)){
                                                        $status = "Following";
                                                    }else{
                                                        $status = "Follow";
                                                    }
                                                @endphp     
                                                <a href="{{ route('follow',$answer->user->name_slug) }}">{{ $status }}</a>
                                                 <a class="text-dark float-right dropdown-toogle" id="navbarDropdown" href="" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre><i class="bi bi-three-dots"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                                    @if ($answer->user_id == auth()->id())
                                                        <a href="" data-attr="{{ route('answer.update',$answer->id) }}" class="dropdown-item" data-toggle="modal" data-target="#answer-updateModal" id="answerUpdate" data-text="{{ $answer->text }}">
                                                            Edit answer
                                                        </a>
                                                        
                                                        <a href="{{ route('answer.destroy',$answer->id) }}" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this answer?')">
                                                            Delete answer
                                                        </a>
                                                    @else
                                                        @php
                                                            $reported_answer = App\Models\ReportAnswer::where('answer_id',$answer->id)->where('user_id',auth()->id())->first();
                                                        @endphp
                                                        @if ($reported_answer)
                                                            <a class="dropdown-item text-danger">
                                                                Reported
                                                            </a>
                                                        @else
                                                            <a href="" class="dropdown-item text-dark" data-toggle="modal" data-target="#report_answerModal" data-attr="{{ route('answer.report',$answer->id) }}" id="reportAnswer">
                                                                Report
                                                            </a>
                                                        @endif
                                                        <a class="dropdown-item">
                                                            Bookmark
                                                        </a>
                                                        <a class="dropdown-item">
                                                            Hide
                                                        </a>
                                                    @endif
                                                </div>
                                                <br>
                                                <div class="text-secondary">
                                                    {{ $credential }} &#183; {{ $answer->created_at->format('M d Y')  }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-12">
                                                {{  $answer->text  }}<br>
                                                @if ($answer->image)
                                                    <img src="{{ asset('img/' . $answer->image) }}" class="img-fluid mt-2 mb-2">
                                                @else
                                                    <div class="mb-2"></div>
                                                @endif
                                                <small class="text-secondary">{{ views($answer)->count() }} views</small>
                                            </div>
                                        </div>

                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('answer.vote',['answer' => $answer->id, 'vote' => 'upvote']) }}" class="text-success mr-2" id="upvote"><i class="bi bi-arrow-up-circle{{ auth()->user()->hasUpVoted($answer) ? '-fill' : '' }}" ></i> {{ $answer->upVoters()->count() }}</a>
                                                    <a href="{{ route('answer.vote',['answer' => $answer->id, 'vote' => 'downvote']) }}" class="text-danger mr-4" id="downvote"><i class="bi bi-arrow-down-circle{{ auth()->user()->hasDownVoted($answer) ? '-fill' : '' }}" ></i> {{ $answer->downVoters()->count() }}</a>
                                                    <a href="javascript: void(0)" class="text-secondary" id="comment"><i class="bi bi-chat"></i> {{ $answer->comments->count() }}</a>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="btn-group float-right" role="group">
                                                    <a href="" class="text-dark" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="bi bi-share"></i></a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                        <a class="dropdown-item" href="{{ $facebook }}#{{ $answer->user->name_slug }}" target="_blank"><i class="bi bi-facebook mr-2"></i>Facebook</a>
                                                        <a class="dropdown-item" href="{{ $twitter }}#{{ $answer->user->name_slug }}" target="_blank"><i class="bi bi-twitter mr-2"></i>Twitter</a>
                                                        <a class="dropdown-item" href="javascript: void(0)" onclick="copy()" data-attr="#{{ $answer->user->name_slug }}" id="copyLink">Copy link</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                      
                                        <div id="show_comment">
                                            <form action="{{ route('comment.store') }}" method="POST">
                                                @csrf
                                                <div class="row mt-3">
                                                    <div class="col-1">
                                                        <img src="{{ auth()->user()->avatar }}" alt="avatar" class="rounded-circle" width="45px" height="45px">
                                                    </div>
                                                    <div class="col-9">
                                                        <input type="text" class="form-control" placeholder="Add a comment..." name="comment" autocomplete="off">
                                                        <input type="hidden" name="answer_id" value="{{ $answer->id }}" id="answer_id">
                                                    </div>
                                                    <div class="col-2">
                                                        <button class="btn btn-primary rounded-pill btn-sm" type="submit">Add comment</button>
                                                    </div>
                                                </div>
                                                @include('layouts.comment',['comments' => $answer->comments,'answer_id' => $answer->id])
                                            </form>
                                        </div>
                                        <script></script>
                                    </div>
                                </div> 
                            </div>
                        </div>
                        </div>
                    @endforeach
                    
                </div>
                
            </div>
           
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    Related Questions
                </div>
                <div class="card-body">
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    // $('#show_comment').hide();

    // //script for comment
    // $(document).on('click','#comment', function(e){
    //     e.preventDefault();
    //     var $a = $(this);
    //     $a.toggleClass('active').siblings().removeClass('active');
    //     $('#show_comment').toggle($a.hasClass('active'));
    // });

    //script for answer report form
    $(document).on('click', '#reportAnswer', function () {
        let href = $(this).attr('data-attr');

        $(document).on('click', '#store-reportAnswer', function () {
            $('#report-answerForm').attr('action', href);
        });
    });

    //script for answer edit modal & form
    $(document).on('click', '#answer', function () {
        let href = $(this).attr('data-attr');

        $(document).on('click', '.store', function () {
            $('#answerForm').attr('action', href);
        });
    });

    //script for update answer
    $(document).on('click', '#answerUpdate', function () {
        let href = $(this).attr('data-attr');
        let text = $(this).attr('data-text');
        $('#textAnswer').val(text);

        $(document).on('click', '.answer-update', function () {
            $('#answer-updateForm').attr('action', href);
        });
    });

    //script for comment report form
    $(document).on('click', '#reportComment', function () {
        let href = $(this).attr('data-attr');

        $(document).on('click', '#store-reportComment', function () {
            $('#report-commentForm').attr('action', href);
        });
    });

    //script for comment update form
    $(document).on('click', '#updateComment', function () {
        let href = $(this).attr('data-attr');
        let text = $(this).attr('data-text');
        console.log(text);
        $('#textComment').val(text);
        $(document).on('click', '.update-comment', function () {
            $('#comment-updateForm').attr('action', href);
        });
    });

    //script for copy link to clipboard
    function copy() {
        let dummy = document.createElement('input');
        let href = $('#copyLink').attr('data-attr');
        let text = window.location.href + href;

        document.body.appendChild(dummy);
        dummy.value = text;
        dummy.select();
        document.execCommand('copy');
        document.body.removeChild(dummy);

        alert('Share link copied to clipboard');
    }

</script>
@endsection