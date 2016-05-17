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
                            <h2>
                                {{ $user->name }}</h2>

                                <i class="glyphicon glyphicon-envelope"></i>{{ $user->email }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection