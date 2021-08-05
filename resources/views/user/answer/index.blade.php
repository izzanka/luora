@extends('layouts.app')

@section('title')
Write Answers
@endsection

@section('content')
@include('layouts.answer')
<div class="container">
    <div class="row">
        <div class="col-md-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        Questions
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <a href="#" class="text-danger">Questions for you</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-7 ml-1">
            
            @include('layouts.success')
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <i class="bi bi-star-fill text-danger"></i> Questions for you
                            <hr>
                        </div>
                    </div>
                    @forelse ($questions as $question)
                        <div class="row">
                            <div class="col-sm-12">
                                <a href="{{ route('question.show',$question->title_slug) }}" class="text-dark"><h5><b>{{ $question->title }}</b></h5></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12"> 
                                <a href="{{ route('question.show',$question->title_slug) }}"><b class="text-secondary">{{ $question->answers->count() ? $question->answers->count() . ' answer' : 'No answer yet'}} </b></a> &#183; 
                                <small>{{ 'last updated ' . $question->updated_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-sm-6">
                                <a href="" data-toggle="modal" data-target="#answerModal" data-attr="{{ route('answer.store',$question->title_slug) }}" id="answer"><i class="bi bi-pencil-square"></i> Answer</a>
                            </div>
                        </div>
                        <hr>
                    @empty
                        <div class="text-center mb-4">No Questions</div>
                    @endforelse
                    
                    <div class="text-center">
                        <button class="btn btn-secondary btn-sm">More</button>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    //script for answer modal
    $(document).on('click','#answer', function(){
        let href = $(this).attr('data-attr');
       
        $(document).on('click','.store', function(){
            $('#answerForm').attr('action',href);
        });
    });
  </script>
@endsection
