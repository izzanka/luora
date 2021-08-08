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
                            <a href="" class="form-control" data-toggle="modal" data-target="#exampleModal">What is your question ?</a>
                        </div>
                    </div>
                </div>
            </div>

            <div id="results"></div>
            <div class="text-center">
                <div class="spinner-border ajax-loading mt-4 text-danger" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="ajax-loading text mt-2"></div>
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

    //script for window loading scroll
    var site_url = "{{ route('home') }}";   
    var page = 1;
   
    load_more(page);

    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() >= $(document).height()) {
        page++;
        load_more(page);
        }
    });

    function load_more(page){
        $.ajax({
          url: site_url + "?page=" + page,
          type: "get",
          datatype: "html",
          beforeSend: function()
          {
            $('.ajax-loading').show();
          }
        })
        .done(function(data){          
          if(data.length == 0){
          $('.ajax-loading.text').html("No more answers");
          return;
        }
          $('.ajax-loading').hide();
          $("#results").append(data);
        })

        .fail(function(jqXHR, ajaxOptions, thrownError)
        {
          alert('No response from server');
        });
    }
    

</script>
@endsection

