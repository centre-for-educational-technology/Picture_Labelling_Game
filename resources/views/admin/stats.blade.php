@extends('layouts.app')

@section('title') Statistics @stop

@section('content')

    <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/stats') }}">
        {!! csrf_field() !!}
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-btn fa-download"></i>Download
        </button>

    </form>
@stop