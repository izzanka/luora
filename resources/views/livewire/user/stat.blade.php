@extends('components.layouts.app')

@section('main')
    <div class="mt-4">
        <b>
            Your content & stats
        </b>
        <form id="sort-all" method="GET" class="d-none">
            <input type="hidden" name="sort" value="all">
        </form>

        <div class="mt-4">
            <b>Overview</b>

            <div class="float-end">
                {{ $sortBy }}
                <svg role="button" data-bs-toggle="dropdown" xmlns="http://www.w3.org/2000/svg" class="ms-2 icon icon-tabler icon-tabler-settings" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"></path>
                    <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                 </svg>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('stats.index') }}">
                        @if($sortBy == 'Last 7 days')
                            <svg xmlns="http://www.w3.org/2000/svg" class="me-2 icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M5 12l5 5l10 -10"></path>
                            </svg>
                        @endif
                        Last 7 days
                    </a>

                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('sort-all').submit()">
                        @if($sortBy == 'All time')
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M5 12l5 5l10 -10"></path>
                        </svg>
                        @endif
                        All time
                    </a>
                </div>

            </div>

            <hr class="mt-3 mb-3">
                @if ($sort == 'day')
                <div class="row">
                    <div class="col-3">
                        <div>
                            Views
                        </div>
                        <b>{{ array_sum($views) }}</b>
                        <canvas id="canvas-views" height="400" width="600" class="mt-2"></canvas>
                    </div>
                    <div class="col-3">
                        <div>
                            Upvotes
                        </div>
                        <b>{{ array_sum($upvotes) }}</b>
                        <canvas id="canvas-upvotes" height="400" width="600" class="mt-2"></canvas>
                    </div>
                    <div class="col-3">
                        <div>
                            Comments
                        </div>
                        <b>{{ array_sum($comments) }}</b>
                        <canvas id="canvas-comments" height="400" width="600" class="mt-2"></canvas>
                    </div>
                    <div class="col-3">
                        <div>
                            Shares
                        </div>
                        <b>{{ array_sum($shares) }}</b>
                        <canvas id="canvas-shares" height="400" width="600" class="mt-2"></canvas>
                    </div>
                </div>
                @elseif($sort == 'all')
                    <div class="row">
                       <canvas id="canvas" height="200" width="600" class="mt-2"></canvas>
                    </div>
                @endif
            </div>

        <div class="mt-4">
            <div>
                <b>Your content</b><br>
                <small>Stats for content from the past 7 days</small>
                <div class="float-end">
                    Filter
                    <span class="ms-2">All types</span>
                    <span class="ms-2 me-2">|</span>
                    Sort
                    <span class="ms-2 me-2">Views</span>
                    <span>Last 7 days</span>
                </div>
            </div>

            <hr class="mt-3 mb-3">
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let views = {{ Js::from($views) }}
        let upvotes = {{ Js::from($upvotes) }}
        let comments = {{ Js::from($comments) }}
        let shares = {{ Js::from($shares) }}
        let labels = {{ Js::from($labels) }}

        console.log(labels)

        if({{ Js::from($sort) }} == 'day')
        {
            let max_views = Math.max(...views);
            let max_upvotes = Math.max(...upvotes);
            let max_comments = Math.max(...comments);
            let max_shares = Math.max(...shares);

            let ctx_views = document.getElementById('canvas-views').getContext('2d')
            let ctx_upvotes = document.getElementById('canvas-upvotes').getContext('2d')
            let ctx_comments = document.getElementById('canvas-comments').getContext('2d')
            let ctx_shares = document.getElementById('canvas-shares').getContext('2d')

            let views_chart = new Chart(ctx_views, {
                type: 'bar',
                options: {
                    animation: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y:{
                            min: 0,
                            max: max_views + 3,
                        }
                    }
                },
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Views',
                        data: views,
                        backgroundColor: '#477FBB',
                    }]
                }
            })

            let upvotes_chart = new Chart(ctx_upvotes, {
                type: 'bar',
                options: {
                    animation: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y:{
                            min: 0,
                            max: max_upvotes + 3,
                        }
                    }
                },
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Upvotes',
                        data: upvotes,
                        backgroundColor: '#477FBB',
                    }]
                }
            })

            let comments_chart = new Chart(ctx_comments, {
                type: 'bar',
                options: {
                    animation: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y:{
                            min: 0,
                            max: max_comments + 3,
                        }
                    }
                },
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Comments',
                        data: comments,
                        backgroundColor: '#477FBB',
                    }]
                }
            })

            let shares_chart = new Chart(ctx_shares, {
                type: 'bar',
                options: {
                    animation: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y:{
                            min: 0,
                            max: max_shares + 3,
                        }
                    }
                },
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Shares',
                        data: shares,
                        backgroundColor: '#477FBB',
                    }]
                }
            })

        }else
        {
            let ctx = document.getElementById('canvas').getContext('2d')

            let chart = new Chart(ctx, {
                type: 'bar',
                options: {
                    animation: false,
                    scales: {
                        y:{
                            min: 0,
                            max: views + 3,
                        }
                    }
                },
                data: {
                    labels: labels,
                    datasets: [{
                        data: [views, upvotes, comments, shares],
                        backgroundColor: '#477FBB',
                    }]
                }
            })
        }
    </script>
@endsection
