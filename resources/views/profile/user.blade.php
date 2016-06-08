@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="well well-sm">
                    <div class="row">
                        <div class="col-sm-8 col-md-4">
                            <img src="{{ $user->gravatar }}?s=200" alt="" class="img-rounded img-responsive" />
                        </div>
                        <div class="col-sm-8 col-md-4">

                                @if($user->role_id == 1)
                                    <h2>{{ $user->name }} <span class="label label-info">Admin</span></h2>
                                @else
                                    <h2>{{ $user->name }} <span class="label label-info">User</span></h2>
                                @endif

                                <span class="glyphicon glyphicon-envelope"></span>{{ $user->email }}

                                    <h3><span class="label label-primary">Personal score: <span class="badge">{{ count($my_matches)+count($others_matches) }}</span></span></h3>

                        </div>
                    </div>
                </div>


                @foreach ($my_matches as $match)
                    <div class="panel panel-info">
                        <div class="panel-heading">Your matches</div>
                        <ul class="list-group">
                            <li class="list-group-item">
                                <p>You played against {{ $match[0] }} on {{ $match[2] }} and got 1 point for the tag "{{ $match[1] }}".</p>
                            </li>
                        </ul>
                    </div>

                @endforeach


                @foreach ($others_matches as $match)
                    <div class="panel panel-info">
                        <div class="panel-heading">Matches against you</div>
                        <ul class="list-group">
                            <li class="list-group-item">
                                <p>{{ $match[0] }} played against you on {{ $match[2] }} and you both got 1 point for the tag "{{ $match[1] }}".</p>
                            </li>
                        </ul>
                    </div>

                @endforeach
            </div>
        </div>
    </div>


@endsection