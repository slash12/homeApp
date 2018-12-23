@extends('layout.layout')
@section('header')
<link rel="icon" href="{{asset('icons/temp-icon.ico')}}">
<title>Temperature | Past readings</title>
<script src="{{ asset('js/Chart.min.js') }}"></script>
<style>
    label.col-sm-1
    {
        padding-top: 0.5%;
    }
    .frm-search-pt
    {
        padding-top:2.5%;
    }
</style>
@endsection
@section('content')
<div class="container">
    <form method="POST" class="frm-search-pt">
        <div class="form-group row">
            <label class="col-sm-1" for="dfrom">From</label>
            <div class="col-sm-3">
                <input type="date" class="form-control" name="dfrom" id="dfrom">
            </div>
            <div class="col-sm-1"></div>
            <label class="col-sm-1" for="dto">To</label>
            <div class="col-sm-3">
                <input type="date" class="form-control" name="dto" id="dto">
            </div>
            <div class="col-sm-1"></div>
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>
    <div class="row">
        
    </div>
</div>
@endsection