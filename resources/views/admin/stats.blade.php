@extends('layouts.app')

@section('title') Statistics @stop

@section('content')

    <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">


                <h1><i class='glyphicon glyphicon-stats'></i> Statistics</h1>


                    <div class="well well-lg"><h2><span class="glyphicon glyphicon-user"></span> Number of registered players: {{ $users}}</h2></div>
                    <div class="well well-lg"><h2><span class="glyphicon glyphicon-tags"></span> Number of unique tags: {{ $tags }}</h2></div>
                    <div class="well well-lg"><h2><span class="glyphicon glyphicon-picture"></span> Number of pictures: {{ $pictures }}</h2></div>
                    <div class="well well-lg"><h2><span class="glyphicon glyphicon-tags"></span> Matching tags: {{ $matchingTags }}</h2></div>




                <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/stats') }}">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-success">
                        <span class="glyphicon glyphicon-download" aria-hidden="true"></span>Download
                    </button>

                </form>

            </div>
        </div>

    </div>
@stop