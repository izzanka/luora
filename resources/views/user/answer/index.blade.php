@extends('layouts.app')

@section('title')
Write Answers
@endsection

@section('content')
@include('layouts.answer')
<div class="container">
    <div class="row">
        <div class="col-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        Questions
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <a href="javascript:void(0)" class="text-danger">Questions for you</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            @include('layouts.success')
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <i class="bi bi-star-fill text-danger"></i> Questions for you
                            <hr>
                        </div>
                    </div>
                    <div id="questionsAnswer">
                        @foreach ($questions as $question)
                            <div class="row">
                                <div class="col-sm-12">
                                    <a href="{{ route('question.show',$question->title_slug) }}" class="text-dark"><h5><b>{{ $question->title }}</b></h5></a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12"> 
                                    <a href="{{ route('question.show',$question->title_slug) }}"><b class="text-secondary">{{ $question->answers->count() ? $question->answers->count() . ' Answer' : 'No answer yet'}} </b></a> &#183; 
                                    <small>{{ 'last updated ' . $question->updated_at->diffForHumans() }}</small>
                                </div>
                            </div>
                
                            <div class="row mt-2">
                                <div class="col-sm-6">
                                    <a href="" data-toggle="modal" data-target="#answerModal" data-attr="{{ route('answer.store',$question->title_slug) }}" id="answer"><i class="bi bi-pencil-square"></i> Answer</a>
                                </div>
                            </div>
                            <hr>
                        @endforeach
                    </div>
                    
                    <div class="text-center">
                        <button class="btn btn-secondary btn-sm moreAnswer rounded-pill" data-page="2" data-link="/answer?page=" data-div="#questionsAnswer">More</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    Topics you know
                </div>
                <div class="card-body">
                    @foreach (auth()->user()->topics as $topic)
                        <a href="{{ route('topic.show',$topic->name_slug) }}" class="text-dark">{{ $topic->name }} 
                        <div class="btn btn-secondary float-right btn-sm rounded-pill">
                        {{ $topic->follower }} Followers</div></a><hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    //script for answer modal
    $(document).on('click', '#answer', function () {
        let href = $(this).attr('data-attr');

        $(document).on('click', '.store', function () {
            $('#answerForm').attr('action', href);
        });
    });

    $(".moreAnswer").click(function () {
        $div = $($(this).data('div')); //div to append
        $link = $(this).data('link'); //current URL

        $page = $(this).data('page'); //get the next page #
        $href = $link + $page; //complete URL
        $.get($href, function (response) { //append data
            $html = $(response).find("#questionsAnswer").html();
            $div.append($html);
        });

        $(this).data('page', (parseInt($page) + 1)); //update page #
    });
  </script>
@endsection
