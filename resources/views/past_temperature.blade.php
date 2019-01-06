@extends('layout.layout')
@section('header')
<link rel="icon" href="{{asset('icons/temp-icon.ico')}}">
<title>Temperature | Past readings</title>
<script src="{{ asset('js/Chart.min.js') }}"></script>
@endsection
@section('content')
<div class="container">
    <form method="POST" action="{{route('searchTemp')}}" class="frm-search-pt">
        @csrf
        <div class="form-group row">
            <label class="col-sm-1" for="dfrom">From</label>
            <div class="col-sm-3">
                <input type="date" value="{{old('dfrom')}}" class="form-control @if ($errors->has('dfrom')) is-invalid @endif" name="dfrom" id="dfrom">
                
            </div>
            <div class="col-sm-1"></div>
            <label class="col-sm-1" for="dto">To</label>
            <div class="col-sm-3">
                <input type="date" value="{{old('dto')}}" class="form-control @if ($errors->has('dto')) is-invalid @endif" name="dto" id="dto">
                
            </div>
            <div class="col-sm-1"></div>
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>
    <div class="row">
        <div class="col canvas-chart-ptemp">
            <canvas id="canvas"></canvas>   
            <script>
                var all_max_temp_init  = "{{$all_max_temp}}";
                var all_max_temp = JSON.parse(all_max_temp_init.replace(/&quot;/g,'"'));
                all_max_temp_value = [];
                for (var i = 0; i < all_max_temp.length; i++) 
                {
                    all_max_temp_value.push(all_max_temp[i]['temp_max']);
                }
    
                var all_min_temp_init  = "{{$all_min_temp}}";
                var all_min_temp = JSON.parse(all_min_temp_init.replace(/&quot;/g,'"'));
                all_min_temp_value = [];
                for (var i = 0; i < all_min_temp.length; i++) 
                {
                    all_min_temp_value.push(all_min_temp[i]['temp_min']);
                }
                
                var all_date_init  = "{{$all_date}}";
                var all_date = JSON.parse(all_date_init.replace(/&quot;/g,'"'));
                all_date_value = [];
                for (var i = 0; i < all_date.length; i++) 
                {
                    all_date_value.push(all_date[i]['formatted_date']);
                }                
    
                var ctx = canvas.getContext('2d');
                var config = {
                type: 'line',
                data: {
                        labels: all_date_value,
                        datasets: [
                            {
                                label: 'Max',
                                data: all_max_temp_value,
                                backgroundColor: 'rgba(240,128,127)',
                                borderColor: 'rgba(240,128,128)',
                                fill:false,
                            },
                            {
                                label: 'Min',
                                data: all_min_temp_value,
                                backgroundColor: 'rgba(0, 118, 204, 0.3)',
                                borderColor: 'rgba(0, 119, 204, 0.3)',
                                fill:false,
                            },
                    ]
                },
                options:
                {
                    responsive: true,
                    title: {
                        display: true,
                        text: 'Past Temperature Readings'
                    },
                    scales:
                    {
                        xAxes:[{
                            display:true,
                            scaleLabel:{
                                display:true,
                                labelString:'Date'
                            }
                        }],
                        yAxes:[{
                            display:true,
                            scaleLabel:{
                                display:true,
                                labelString:'Temperature'
                            }
                        }]
                    }
                }
                };
            
                var chart = new Chart(ctx, config);
            </script>   
        </div>
    </div>
</div>

    @section('script')
        @if ($errors->has('dfrom'))
            <script>
                iziToast.warning({
                    title: 'Caution',
                    message: "{{ $errors->first('dfrom') }}",
                });
            </script>
        @endif

        @if ($errors->has('dto'))
            <script>
                iziToast.warning({
                    title: 'Caution',
                    message: "{{ $errors->first('dto') }}",
                });
            </script>
        @endif
    @endsection

@endsection