<!-- Modal -->
<form action="" method="POST" id="answerForm">
    @csrf
        <div class="modal fade" id="answerModal" tabindex="-1" aria-labelledby="answerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="answerModalLabel">
                    <img src="{{ Auth::user()->avatar }}" alt="avatar" class="rounded-circle mr-2" width="42px" height="42px">
                    {{ Auth::user()->name }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
            
                <div class="modal-body">
                    <textarea name="text" id="" cols="30" rows="10" class="form-control" placeholder="Write your answer"></textarea>
                </div>
            
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary store">Post</button>
                </div>
            </div>
            </div>
        </div>
</form>