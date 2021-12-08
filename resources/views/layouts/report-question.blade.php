<form action="{{ route('question.report',$question->title_slug) }}" method="POST">
    @csrf
    <div class="modal fade" id="report_questionModal" aria-labelledby="report_questionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="report_questionModalLabel">Report question</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="form-check">
                    @foreach ($report_question_types as $report_question_type)
                        <input class="form-check-input" type="radio" name="type" id="{{ $report_question_type['name'] }}" value="{{ $report_question_type['name'] }}">
                        <label class="form-check-label" for="{{ $report_question_type['name'] }}">
                            <b>{{ $report_question_type['name'] }}</b><br>
                            <span class="text-secondary">{{ $report_question_type['desc'] }}</span>
                        </label>
                        <br><br>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-text rounded-pill" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary rounded-pill">Submit</button>
            </div>
        </div>
        </div>
    </div>
</form>