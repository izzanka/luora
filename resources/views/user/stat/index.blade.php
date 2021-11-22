@extends('layouts.app')

@section('title')
Stats
@endsection
@section('link')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')

<div class="container">
    <div class="row">
       <div class="col-12">
           <div class="card">
               <div class="card-header">Stats</div>
                <div class="card-body">
                    <canvas id="canvas" height="200" width="600"></canvas>
                </div> 
           </div>
       </div>
    </div>
</div>
@endsection
@section('script')
<script>
    
    let url = "{{route('stats.show')}}";
    let Views = new Array();

    $.ajax({
            url: url,
            type: 'get',
            dataType: 'json',
        })
        .done(function (data) {
            var ctx = document.getElementById("canvas").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    datasets: [{
                        label: 'Total Views',
                        data: data,
                        backgroundColor: '#84B1E1',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                }
            });
        });

</script>
@endsection
