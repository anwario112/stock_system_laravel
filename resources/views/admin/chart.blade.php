@extends('admin.dashboard')
@section('content')


<div style="width:900px;margin:auto">
<canvas id="chart"></canvas>
</div>


@section('script')
<script>
     var ctx = document.getElementById('chart').getContext('2d');
    var userChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($labels) ?>,
            datasets: <?= json_encode($datasets) ?>
        },
    });
</script>
@endsection

@endsection