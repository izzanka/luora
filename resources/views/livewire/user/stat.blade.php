@extends('components.layouts.app')

@section('main')
<div class="mt-4">
    <b>
        Your content & stats
    </b>

    <div class="mt-4">
        <b>
            Overview
        </b>
        <hr class="mt-3 mb-3">
        <div class="row">
            {{-- <div class="col-3">
                <div>
                    Views
                </div>
                <div class="mt-1">
                    <b>{{ $views['Views'] }}</b>
                </div>
                <canvas id="canvas-views" height="500" width="600" class="mt-2"></canvas>
            </div>
            <div class="col-3">
                <div>
                    Upvotes
                </div>
                <div class="mt-1">
                    <b>{{ $upvotes['Upvotes'] }}</b>
                </div>
                <canvas id="canvas-upvotes" height="500" width="600" class="mt-2"></canvas>
            </div>
            <div class="col-3">
                <div>
                    Comments
                </div>
                <div class="mt-1">
                    <b>{{ $comments['Comments'] }}</b>
                </div>
                <canvas id="canvas-comments" height="500" width="600" class="mt-2"></canvas>
            </div>
            <div class="col-3">
                test
            </div> --}}
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
{{-- <script>
    let total_views = {{ Js::from($views) }}
    let total_upvotes = {{ Js::from($upvotes) }}
    let total_comments = {{ Js::from($comments) }}
    let answers = {{ Js::from($answers) }}
    let answers_date = {{ Js::from($labels) }}
    console.log(answers)

    let ctx_views = document.getElementById('canvas-views').getContext('2d')
    let ctx_upvotes = document.getElementById('canvas-upvotes').getContext('2d')
    let ctx_comments = document.getElementById('canvas-comments').getContext('2d')

    new Chart(ctx_views, {
        type: 'bar',
        data: {
            labels: answers_date,
            datasets: [{
                label: 'Views',
                data: answers,
                backgroundColor: '#477FBB',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    })

    new Chart(ctx_upvotes, {
        type: 'bar',
        data: {
            datasets: [{
                label: 'Upvotes',
                data: total_upvotes,
                backgroundColor: '#477FBB',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    })

    new Chart(ctx_comments, {
        type: 'bar',
        data: {
            datasets: [{
                label: 'Comments',
                data: total_comments,
                backgroundColor: '#477FBB',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    })
</script> --}}

@endsection

