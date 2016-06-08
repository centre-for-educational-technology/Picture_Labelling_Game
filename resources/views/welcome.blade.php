@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>

                <div class="panel-body">
                    <h1 class="text-center"><i class='glyphicon glyphicon-bullhorn'></i> How to play</h1>


                    <ul class="list-group">
                        <li class="list-group-item list-group-item-warning"><h3><span class="glyphicon glyphicon-picture"></span>1. Get a random picture from our library</h3></li>
                        <li class="list-group-item list-group-item-info"><h3><span class="glyphicon glyphicon-tags"></span>2. Tag that picture </h3></li>
                        <li class="list-group-item list-group-item-danger"><h3><span class="glyphicon glyphicon-exclamation-sign"></span>3. Do not use tags in taboo list</h3></li>
                        <li class="list-group-item list-group-item-success"><h3><span class="glyphicon glyphicon-star"></span>4. Get points for the matches against your competitor </h3></li>
                    </ul>

                    {{--<div class="well well-lg"><h3><span class="glyphicon glyphicon-picture"></span>1. Get a random picture from our library</h3></div>--}}
                    {{--<div class="well well-lg"><h3><span class="glyphicon glyphicon-tags"></span>2. Tag that picture </h3></div>--}}
                    {{--<div class="well well-lg"><h3><span class="glyphicon glyphicon-exclamation-sign"></span>3. Do not use tags in taboo list</h3></div>--}}
                    {{--<div class="well well-lg"><h3><span class="glyphicon glyphicon-star"></span>4. Get points for the matches against your competitor </h3></div>--}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
