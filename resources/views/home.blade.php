@extends('layouts.app')

@section('header')
    {{--<style type="text/css">--}}
        {{--div[ng-controller] {--}}
            {{--margin-bottom: 1em;--}}
            {{---webkit-border-radius: 4px;--}}
            {{--border-radius: 4px;--}}
            {{--border: 1px solid;--}}
            {{--padding: .5em;--}}
        {{--}--}}
        {{--div[ng-controller^=Good] {--}}
            {{--border-color: #d6e9c6;--}}
            {{--background-color: #dff0d8;--}}
            {{--color: #3c763d;--}}
        {{--}--}}
        {{--div[ng-controller^=Bad] {--}}
            {{--border-color: #ebccd1;--}}
            {{--background-color: #f2dede;--}}
            {{--color: #a94442;--}}
            {{--margin-bottom: 0;--}}
        {{--}--}}
    {{--</style>--}}
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular.min.js"></script>
    <script type="text/javascript">
    @include('angularr')
    </script>
@endsection



@section('content')
<div class="container">
    <div class="row">

            <div class="jumbotron">
                <div class="container">



                    @include('angular')
                </div>



            </div>


    </div>
</div>
@endsection
