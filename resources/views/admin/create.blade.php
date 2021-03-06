@extends('layouts.app')

@section('title') Create User @stop

@section('content')

    <div class='col-md-8 col-md-offset-2'>

        @if ($errors->has())
            @foreach ($errors->all() as $error)
                <div class='bg-danger alert'>{{ $error }}</div>
            @endforeach
        @endif
        @include('flash::message')

        <div class="panel panel-default">
            <div class="panel-heading">
                <h1><span class='glyphicon glyphicon-user'></span> Add User</h1>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin') }}">
                    {!! csrf_field() !!}

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Name</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}">

                            @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Role</label>

                        <div class="col-md-6">
                            <select class="form-control" name="role" type="select">
                                <option value="0" selected>User</option>
                                <option value="1">Admin</option>
                            </select>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">E-Mail Address</label>

                        <div class="col-md-6">
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Password</label>

                        <div class="col-md-6">
                            <input type="password" class="form-control" name="password">

                            @if ($errors->has('password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Confirm Password</label>

                        <div class="col-md-6">
                            <input type="password" class="form-control" name="password_confirmation">

                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                <span class="glyphicon glyphicon-user"></span>Register
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        {{--{{ Form::open(['role' => 'form', 'url' => '/admin']) }}--}}

        {{--<div class='form-group'>--}}
            {{--{{ Form::label('name', 'Name') }}--}}
            {{--{{ Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) }}--}}
        {{--</div>--}}

        {{--<div class='form-group'>--}}
            {{--{{ Form::label('email', 'Email') }}--}}
            {{--{{ Form::email('email', null, ['placeholder' => 'Email', 'class' => 'form-control']) }}--}}
        {{--</div>--}}

        {{--<div class='form-group'>--}}
            {{--{{ Form::label('password', 'Password') }}--}}
            {{--{{ Form::password('password', ['placeholder' => 'Password', 'class' => 'form-control']) }}--}}
        {{--</div>--}}

        {{--<div class='form-group'>--}}
            {{--{{ Form::label('password_confirmation', 'Confirm Password') }}--}}
            {{--{{ Form::password('password_confirmation', ['placeholder' => 'Confirm Password', 'class' => 'form-control']) }}--}}
        {{--</div>--}}

        {{--<div class='form-group'>--}}
            {{--{{ Form::label('role', 'Set Role') }}--}}
            {{--{{ Form::password('password_confirmation', ['placeholder' => 'Confirm Password', 'class' => 'form-control']) }}--}}
        {{--</div>--}}

        {{--<div class='form-group'>--}}
            {{--{{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}--}}
        {{--</div>--}}

        {{--{{ Form::close() }}--}}

    </div>

@stop