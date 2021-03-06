@extends('administrators/statistics/index')

@section('js')
@parent
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['{{ trans("statistics.months") }}', '{{ trans("patients.patient") }}'],

          @foreach ($data as $month)
            ['{{ $month['value'] }}', {{ $month['total'] }}],
          @endforeach
        ]);

        var options = {
          title: '{{ trans("statistics.patient_flow") }}',
          hAxis: {title: '{{ trans("statistics.months") }}',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
</script>
@endsection

@section('graphs')
  <div id="chart_div" style="width: 100%; height: 500px;"></div>
@endsection

