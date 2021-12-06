@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-2">
            <div class="card">
                <div class="card-header">
                    Create Topics
                </div>
                <div class="card-body">
                </div>
            </div>
        </div>
        <div class="col-7 ml-1">
            @include('layouts.success')
            
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <img src="{{ Auth::user()->avatar }}" alt="avatar" class="rounded-circle mr-2" width="42px" height="42px">
                            <b>{{ Auth::user()->name }}</b>
                        </div>
                        <div class="col-sm-12 mt-3">
                            <a href="" class="form-control text-dark" data-toggle="modal" data-target="#add-questionModal">What is your question ?</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="answers">
                @foreach ($answers as $answer)
                    
                    @php
                        //count view
                        views($answer)
                        ->cooldown(86400)
                        ->record();
                        //count question
                        views($answer->question)
                        ->cooldown(86400)
                        ->record();

                        //set share
                        $link = route('question.show',$answer->question);
                        $facebook = \Share::page($link)->facebook()->getRawLinks();
                        $twitter = \Share::page($link)->twitter()->getRawLinks();

                        //set credential
                        if($answer->user->credential){
                            $credential = $answer->user->credential;
                        }else{
                            $answer->user->load(['employment','education','location']);
                            if($answer->user->employment){
                                $year_or_current_employment = $answer->user->employment->currently ? 'now' : $answer->user->employment->end_year;
                                $credential = $answer->user->employment->position . ' at ' . $answer->user->employment->company . ' (' . $answer->user->employment->start_year . ' - ' . $year_or_current_employment . ')';
                            }else{
                                if($answer->user->education){
                                    $year_or_current_education= $answer->user->education->graduation_year ? ' (Graduated ' . $answer->user->education->graduation_year . ')' : null;
                                    $credential = $answer->user->education->degree_type . ' in ' . $answer->user->education->primary . ', ' . $answer->user->education->school . $year_or_current_education;
                                }else{
                                    if($answer->user->location){
                                        $year_or_current_location = $answer->user->location->currently ? 'now' : $answer->user->location->end_year;
                                        $credential = 'Lives in ' . $answer->user->location->location . ' (' . $answer->user->location->start_year . ' - ' . $year_or_current_location . ')';
                                    }else{
                                        $credential = '';
                                    }
                                }
                            }
                        }

                        //set vote status
                        if(auth()->user()->hasUpVoted($answer)){
                            $upvoted = "-fill";
                        }else{
                            $upvoted = "";
                        }

                        if(auth()->user()->hasDownVoted($answer)){
                            $downvoted = "-fill";
                        }else{
                            $downvoted = "";
                        }

                        //set follow status
                        if(auth()->user()->isFollowing($answer->user)){
                            $status = "Following";
                        }else{
                            $status = "Follow";
                        }

                    @endphp
                        <div class="card mt-3" id="{{ $answer->user->name_slug }}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row mb-3">
                                            <div class="col-sm-1">
                                                <img src="{{ $answer->user->avatar }}" alt="avatar" class="rounded-circle" width="42px" height="42px">
                                            </div>
                                        
                                            <div class="col-sm-11">
                                                <a href="{{ route('profile.show',$answer->user->name_slug) }}" class="text-dark"><b>{{  $answer->user->name }} </b></a> &#183; 
                                                <a href="{{ route('follow',$answer->user->name_slug) }}">{{ $status }}</a>
                                                <a href="" class="text-dark float-right dropdown-toogle" id="navbarDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre><i class="bi bi-three-dots" style="font-size: 20px"></i></a><br>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown"> 
                                                    <a class="dropdown-item">
                                                        Report
                                                    </a>
                                                    <a class="dropdown-item">
                                                        Bookmark
                                                    </a>
                                                    <a class="dropdown-item">
                                                        Hide
                                                    </a>
                                                </div>
                                                    {{ $credential }} &#183; {{ $answer->created_at->format('M d Y') }}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <a href="{{ route('question.show',$answer->question->title_slug) }}" class="text-dark"><h5><b>{{ $answer->question->title }}</b></h5></a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                {{ $answer->text }}<br><br>
                                                @php
                                                    $images = json_decode($answer->images);
                                                @endphp
                                                @if ($answer->images)
                                                    @foreach ($images as $image)
                                                        <img src="{{ asset('img/' . $image) }}" class="img-fluid mt-2 mb-2 ">
                                                    @endforeach
                                                @endif
                                                <small class="text-secondary">{{ views($answer)->count() }} views</small>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('answer.vote',['question' => $answer->question->title_slug,'answer' => $answer->id, 'vote' => 'upvote'])}}" class="text-success mr-2" ><i class="bi bi-arrow-up-circle{{ $upvoted }}"></i> {{ $answer->upVoters()->count() }}</a>
                                                    <a href="{{ route('answer.vote',['question' => $answer->question->title_slug,'answer' => $answer->id, 'vote' => 'downvote'])}}" class="text-danger mr-4" ><i class="bi bi-arrow-down-circle{{ $downvoted }}"></i> {{ $answer->downVoters()->count() }}</a>
                                                    <a href="{{ $answer->question->title_slug ."#". $answer->user->name_slug }}" class="text-secondary"><i class="bi bi-chat"></i> {{ $answer->comments->count() }}</a>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="btn-group float-right" role="group">
                                                <a href="" class="text-dark" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bi bi-share"></i></a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                        <a class="dropdown-item" href="{{ $facebook . '#'.$answer->user->name_slug}} '. '" target="_blank"><i class="bi bi-facebook mr-2"></i>Facebook</a>
                                                        <a class="dropdown-item" href="{{ $twitter . '#'.$answer->user->name_slug}}'.'" target="_blank"><i class="bi bi-twitter mr-2"></i>Twitter</a>
                                                        <a class="dropdown-item" href="javascript: void(0)" onclick="copy()" id="copyLink" data-attr="{{ $answer->question->title_slug ."#". $answer->user->name_slug }}">Copy link</a>
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

            <div class="text-center">
                <button class="btn btn-secondary btn-sm more mt-2" data-page="5" data-link="/home?page=" data-div="#answers">More</button>
            </div>

        </div>

        <div class="col-md-2">
            <div class="card mb-3">
                <div class="card-header">
                    Improve your feed
                </div>
                <div class="card-body">
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    Topics to follow
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

    let env_url = "{{ env('APP_URL') }}";

    $(".more").click(function () {
        $div = $($(this).data('div')); //div to append
        $link = $(this).data('link'); //current URL

        $page = $(this).data('page'); //get the next page #
        $href = $link + $page; //complete URL
        $.get($href, function (response) { //append data
            $html = $(response).find("#answers").html();
            $div.append($html);
        });

        $(this).data('page', (parseInt($page) + 1)); //update page #
    });
    
    // let site_url = "{{ route('home') }}";
    // let page = 1;

    // //script for window loading scroll
    // load_more(page);

    // $(window).scroll(function () {
    //     if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
    //         page++;
    //         load_more(page);
    //     }
    // });

    // function load_more(page) {
    //     $.ajax({
    //             url: site_url + "?page=" + page,
    //             type: "get",
    //             datatype: "html",
    //             beforeSend: function () {
    //                 $('.ajax-loading').show();
    //             }
    //         })
    //         .done(function (data) {
    //             if (data.length == 0) {
    //                 $('.ajax-loading.text').html("No more answers");
    //                 return;
    //             }
    //             $('.ajax-loading').hide();
    //             $("#results").append(data['data']);

    //             if(data['images'] != null){
    //                 $.each(data['images'], function(id, image){
    //                     $('#images').append('<img src="img/' + image + '" class="img-fluid mt-2 mb-2">');
    //                 });
    //             }
    //         })

    //         .fail(function (jqXHR, ajaxOptions, thrownError) {
    //             console.log('No response from server');
    //         });
    // }

    //script for copy link to clipboard
    function copy() {
        let dummy = document.createElement('input');
        let href = $('#copyLink').attr('data-attr');
        let text = env_url + href;

        document.body.appendChild(dummy);
        dummy.value = text;
        dummy.select();
        document.execCommand('copy');
        document.body.removeChild(dummy);

        alert('Link copied to clipboard');
    }

</script>
@endsection

