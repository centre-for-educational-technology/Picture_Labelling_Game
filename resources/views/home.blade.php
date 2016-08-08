@extends('layouts.app')

@section('header')


    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular.min.js"></script>
    <script type="text/javascript">
    @include('angularjs')
        var apiUrl = "{{ url('api/game') }}";
    </script>
@endsection



@section('content')

    @include('angular')

@endsection
