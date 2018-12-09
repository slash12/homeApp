@extends('layout.layout')
@section('header')
<title>Home | Temperature</title>
<style>
    .row, .col, .col-3, .col-9
    {
        border:1px solid black;
    }
</style>
@endsection
@section('content')
<div class="row">
    <div class="col">
        Temperature Graph
        <div id="temps-div"></div>
        @linechart('Temps', 'temps_div')
    </div>
</div>
<div class="row">
    <div class="col-9">
        <table class="table table-hover">
            <thead>
                <th>Timestamp</th>
                <th>Max Temperature</th>
                <th>Min Temperature</th>
            </thead>
            <tbody>
                @foreach ($all_temp as $temp)
                    <tr class="table-light">
                        <td>{{ $temp->created_at }}</td>
                        <td>{{ $temp->temp_max }}</td>
                        <td>{{ $temp->temp_min }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-3">
        <button type="button" data-toggle="modal" data-target="#tempModal" name="btnaddtemp" class="btn btn-primary">Add Temperature </button>
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
          <form method="post" action="{{ route('saveTemp') }}">
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
                title: 'Temperature',
                message: 'was added',
            });
        </script>
    @endif
  @endsection
@endsection