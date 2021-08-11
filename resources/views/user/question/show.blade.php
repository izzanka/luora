@extends('layouts.app')

@section('title')
{{ $question->title }}
@endsection

@section('content')
@include('layouts.answer')

<!-- Modal Question-->
<form action="{{ route('question.update',$question->title_slug) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="modal fade" id="questionModal" tabindex="-1" aria-labelledby="questionModalLabel" aria-hidden="true">
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
                        <input type="text" name="title" value="{{ $question->title }}" class="form-control">
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
    <div class="modal fade" id="topicModal" tabindex="-1" aria-labelledby="topicModalLabel" aria-hidden="true">
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
                                            <input class="form-check-input" type="checkbox" value="{{ $topic->id }}" id="defaultCheck1" name="topic_id[]"
                                            @php
                                                $checked = "";
                                                foreach($question->topics as $qtopic){
                                                    if($qtopic->name == $topic->name){
                                                        $checked = "checked";
                                                    }
                                                }
                                            @endphp 
                                            {{ $checked }}>
                                            <label class="form-check-label" for="defaultCheck1">
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
                                                    <a href="" class="text-secondary text-center">{{ $topic->name }}</a>
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
                                 
                                    @if ($question->user_id == auth()->id())
                                        <span class="text-secondary"><i class="bi bi-pencil-square"></i> Answer</span>
                                    @else
                                        <a href="" data-toggle="modal" data-target="#answerModal" data-attr="{{ route('answer.store',$question->title_slug) }}" id="answer"><i class="bi bi-pencil-square"></i> Answer</a>                   
                                    @endif

                                    <a class="text-dark float-right dropdown-toogle" id="navbarDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre><i class="bi bi-three-dots"></i></a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        @if ($question->user_id == auth()->id())
                                        <a href="" class="dropdown-item" data-toggle="modal" data-target="#questionModal">
                                            Edit question
                                        </a>
                                        <a href="" class="dropdown-item" data-toggle="modal" data-target="#topicModal">
                                            Edit topics
                                        </a>

                                        <a href="{{ route('question.destroy',$question->title_slug) }}" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this question?')">
                                            Delete question
                                        </a>
                                        @else
                                        <a class="dropdown-item">
                                            Bookmark
                                            </a>
                                            <a class="dropdown-item">
                                                Report
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
                        @php
                        
                            views($answer)
                            ->cooldown(86400)
                            ->record();

                            $credential = "";
                            if($answer->user->credential){
                                $credential = $answer->user->credential;
                            }else{
                                $answer->user->load(['employment','education','location']);
                                if($answer->user->employment){
                                    $end = $answer->user->employment->currently ? 'present' : $answer->user->employment->end_year;
                                    $credential = $answer->user->employment->position . ' at ' . $answer->user->employment->company . ' (' . $answer->user->employment->start_year . '-' . $end . ')';
                                }else{
                                    if($answer->user->education){
                                        $end2 = $answer->user->education->graduation_year ? ' (Graduated ' . $answer->user->education->graduation_year . ')' : null;
                                        $credential = $answer->user->education->degree_type . ' in ' . $answer->user->education->primary . ', ' . $answer->user->education->school . $end2;
                                    }else{
                                        if($answer->user->location){
                                            $end3 = $answer->user->location->currently ? 'present' : $answer->user->location->end_year;
                                            $credential = 'Lives in ' . $answer->user->location->location . ' (' . $answer->user->location->start_year . '-' . $end3 . ')';
                                        }
                                    }
                                }
                            }
                        @endphp
                        <!-- Modal Answer-->
                        <form action="" method="POST" id="answer-updateForm">
                            @csrf
                            @method('PUT')
                            <div class="modal fade" id="answer-updateModal" tabindex="-1" aria-labelledby="answer-updateModalLabel" aria-hidden="true">
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
                                                <textarea name="text" cols="10" rows="7" class="form-control" id="text"></textarea>
                                                @include('layouts.error', ['name' => 'text'])
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-light rounded-pill" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary store-update rounded-pill">Update</button>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </form>

                        <div class="card mt-2" id="{{ $answer->user->name_slug }}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <img src="{{$answer->user->avatar}}" alt="avatar" class="rounded-circle" width="42px" height="42px">
                                            </div>
                                             
                                            <div class="col-sm-11">
                                                <b><a href="{{ route('profile.show',$answer->user->name_slug) }}" class="text-dark">{{ $answer->user->name  }}</a></b>, 
                                                {{ $credential }} <a class="text-dark float-right dropdown-toogle" id="navbarDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre><i class="bi bi-three-dots"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                                    @if ($answer->user_id == auth()->id())
                                                        <a href="" data-attr="{{ route('answer.update',$answer->id) }}" class="dropdown-item" data-toggle="modal" data-target="#answer-updateModal" id="answerUpdate" data-text="{{ $answer->text }}">
                                                            Edit answer
                                                        </a>
                                                        
                                                        <a href="{{ route('answer.destroy',$answer->id) }}" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this answer?')">
                                                            Delete answer
                                                        </a>
                                                    @else
                                                        <a class="dropdown-item">
                                                            Bookmark
                                                        </a>
                                                        <a class="dropdown-item">
                                                            Report
                                                        </a>
                                                        <a class="dropdown-item">
                                                            Hide
                                                        </a>
                                                    @endif
                                                </div>
                                                <br>
                                                <div class="text-secondary">
                                                    Answered {{ $answer->created_at->format('M d, Y')  }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-12">
                                                {{  $answer->text  }}<br>
                                                <small class="text-secondary">{{ views($answer)->count() }} views</small>
                                            </div>
                                        </div>

                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="btn-group" role="group">
                                                    <a href="{{  route('answer.vote',['question' => $answer->question->title_slug,'answer' => $answer->id, 'vote' => 'upvote'])}}" class="text-success mr-2" id="upvote"><i class="bi bi-arrow-up-circle{{ auth()->user()->hasUpVoted($answer) ? '-fill' : '' }}" ></i> {{ $answer->upVoters()->count() }}</a>
                                                    <a href="{{  route('answer.vote',['question' => $answer->question->title_slug,'answer' => $answer->id, 'vote' => 'downvote']) }}" class="text-danger mr-4" id="downvote"><i class="bi bi-arrow-down-circle{{ auth()->user()->hasDownVoted($answer) ? '-fill' : '' }}" ></i> {{ $answer->downVoters()->count() }}</a>
                                                    <a href="" class="text-secondary"><i class="bi bi-chat"></i> 0</a>
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
    //script for answer modal & form
    $(document).on('click','#answer', function(){
        let href = $(this).attr('data-attr');
       
        $(document).on('click','.store', function(){
            $('#answerForm').attr('action',href);
        });
    });

    //script for update answer
    $(document).on('click','#answerUpdate', function(){
        let href = $(this).attr('data-attr');
        let text = $(this).attr('data-text');
        $('#text').val(text);
        $(document).on('click','.store-update', function(){
            $('#answer-updateForm').attr('action',href);
        });
    });

    //script for copy link to clipboard
    function copy(){
        let dummy = document.createElement('input');
        let href = $('#copyLink').attr('data-attr');
        let text = window.location.href + href;

        document.body.appendChild(dummy);
        dummy.value = text;
        dummy.select();
        document.execCommand('copy');
        document.body.removeChild(dummy);

        alert('Link copied to clipboard');
    }

</script>
@endsection