<!-- Modal -->
<form action="" method="POST" id="answerForm" enctype="multipart/form-data">
    @csrf
        <div class="modal fade" id="answerModal" aria-labelledby="answerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="answerModalLabel">
                        <img src="{{ Auth::user()->avatar }}" alt="avatar" class="rounded-circle mr-2" width="42px" height="42px">
                        {{ Auth::user()->name }}
                    </h5>
                </div>
            
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                <div class="container">
                                    <li>Image must be less than 2MB</li>
                                    <li>Image will be placed under the text of your answer</li>
                                </div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                               <textarea name="text" cols="30" rows="10" class="form-control" placeholder="Write your answer" autocomplete="off" autofocus id="text"></textarea>
                               @include('layouts.error', ['name' => 'text'])
                               <input type="file" name="image" accept="image/*" class="form-control mt-2"> 
                        </div>
                    </div>


                </div>

            
                <div class="modal-footer">
                    <button type="button" class="btn btn-light rounded-pill" data-dismiss="modal" id="close">Close</button>
                    <button type="submit" class="btn btn-primary store rounded-pill">Add Answer</button>
                </div>
            </div>
            </div>
        </div>
</form>

<script>
 
    $(document).on('click', '#close', function () {
        $('#text').val("");
        $('#images').val("");
    });

</script>