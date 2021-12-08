<!-- Report Answer Modal -->
<form method="POST" id="report-answerForm">
    @csrf
    <div class="modal fade" id="report_answerModal" aria-labelledby="report_answerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="report_answerModalLabel">Report answer</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="form-check">
                    @foreach ($report_answer_types as $report_answer_type)
                        <input class="form-check-input" type="radio" name="type" id="{{ $report_answer_type['name'] }}" value="{{ $report_answer_type['name'] }}">
                        <label class="form-check-label" for="{{ $report_answer_type['name'] }}">
                            <b>{{ $report_answer_type['name'] }}</b><br>
                            <span class="text-secondary">{{ $report_answer_type['desc'] }}</span>
                        </label>
                        <br><br>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-text rounded-pill" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary rounded-pill" id="store-reportAnswer">Submit</button>
            </div>
        </div>
        </div>
    </div>
</form>