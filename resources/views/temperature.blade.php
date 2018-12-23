@extends('layout.layout')
@section('header')
<link rel="icon" href="{{asset('icons/temp-icon.ico')}}">
<link rel="stylesheet" href="{{ asset('css/balloon.min.css') }}">
<title>Home | Temperature</title>
<script src="{{ asset('js/Chart.min.js') }}"></script>
@endsection
@section('content')
<div class="row">
    <div class="col canvas-chart">
        <canvas id="canvas" height="75"></canvas>   
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
					text: 'Weekly Temperature Readings'
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
<div class="row temp-tbl-btn">
    <div class="col-9">
        <table class="table table-hover temp-table">
            <thead>
                <th>Timestamp</th>
                <th>Max Temperature</th>
                <th>Min Temperature</th>
                <th>Action</th>
            </thead>
            <tbody>
                @foreach ($all_temp_five as $temp)
                    <tr class="table-light">
                        <td>{{ $temp->created_at }}</td>
                        <td>{{ $temp->temp_max }}</td>
                        <td>{{ $temp->temp_min }}</td>
                        <td>                            
                            <a class="temp-btn-delete" href="/temp/delete/{{ $temp->id }}">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-3">
        @if( $temp_rec_fl == true)
            <button type="button" class="btn btn-primary" data-balloon="Today's reading already recorded!" data-balloon-pos="up" disabled>Add Temperature</button>
        @else
            <button type="button" data-toggle="modal" data-target="#tempModal" name="btnaddtemp" class="btn btn-primary">Add Temperature</button>
        @endif

        <a href="/temp/past" class="btn btn-secondary btn-temp-past">View Past Readings</a>
    </div>
</div>

<div class="modal fade" id="tempModal" tabindex="-1" role="dialog" aria-labelledby="tempModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="tempModalLabel">Add Temperature for today</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="frmtemp" method="post" action="{{ route('saveTemp') }}">
              @csrf              
                <div class="form-group">
                    <label for="txttempmax">Max Temperature</label>
                    <input type="text" maxlength="5" value="{{ old('txttempmax') }}" class="form-control @if ($errors->has('txttempmax')) is-invalid @endif" name="txttempmax" id="txttempmax" placeholder="Maximum Temperature">
                    @if ($errors->has('txttempmax'))
                        <div class="invalid-feedback">{{ $errors->first('txttempmax') }}</div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="txttempmax">Min Temperature</label>
                    <input type="text" maxlength="5" value="{{ old('txttempmin') }}" class="form-control @if ($errors->has('txttempmin')) is-invalid @endif" name="txttempmin" id="txttempmin" placeholder="Minimum Temperature">
                    @if ($errors->has('txttempmin'))
                        <div class="invalid-feedback">{{ $errors->first('txttempmin') }}</div>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  @section('script')
    <script>
        $('.temp-btn-delete').on("click", function(e)
        {
            e.preventDefault();
            var href = $(this).attr('href');            
            $.confirm({
                title: 'Confirmation Message',
                content: 'Are you Sure?',
                type: 'red',
                typeAnimated: true,
                buttons: 
                {
                    Yes: function () 
                    {
                        window.location=href
                    },
                    No: function () 
                    {
                        backgroundDismiss: true
                    }
                }
            });
        });
    </script>

    @if (session('status') == 'deleted-temp')
        <script>
            iziToast.success({
                title: 'Temperature readings',
                message: 'deleted',
            });
        </script>                                         
    @endif

    @if (!$errors->isEmpty())
        <script>
            $(document).ready(function()
            {                
                $('#tempModal').modal('show');
            });     
        </script>
    @endif
    @if(session('temp-alert')=="Success")
        <script>
            iziToast.success({
                title: 'Temperature readings',
                message: 'was added',
            });
        </script>
    @endif
  @endsection

@endsection