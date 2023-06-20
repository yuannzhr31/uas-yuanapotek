@extends('app')
@section('content')

<select class="sel" name="year">
            <option value="2019">Year 2023</option>
            <option value="2019">Year 2022</option>
            <option value="2019">Year 2021</option>
            <option value="2019">Year 2020</option>
            <option value="2019">Year 2019</option>
            <option value="2018">Year 2018</option>
            <option value="2017">Year 2017</option>
        </select>
  
        <div style="width: 80%;margin: 0 auto;">
            {!! $chart->container() !!}
        </div>
          
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
  
        {!! $chart->script() !!}
  
        <script type="text/javascript">
            var original_api_url = {{ $chart->id }}_api_url;
            $(".sel").change(function(){
                var year = $(this).val();
                {{ $chart->id }}_refresh(original_api_url + "?year="+year);
            });
        </script>
@endsection