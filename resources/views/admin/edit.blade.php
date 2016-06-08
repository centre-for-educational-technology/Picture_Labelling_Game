@extends('layouts.app')

@section('title') Edit User @stop

@section('content')

    <div class='col-md-8 col-md-offset-2'>
        @if ($errors->has())
            @foreach ($errors->all() as $error)
                <div class='bg-danger alert'>{{ $error }}</div>
            @endforeach
        @endif

        {{--@if ($errors->has())--}}
            {{--@foreach ($errors->all() as $error)--}}
                {{--<div class='bg-danger alert'>{{ $error }}</div>--}}
            {{--@endforeach--}}
        {{--@endif--}}

        {{--<h1><i class='fa fa-user'></i> Edit User</h1>--}}

        {{--{{ Form::model($user, ['role' => 'form', 'url' => '/admin/' . $user->id, 'method' => 'PUT']) }}--}}


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
            {{--{{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}--}}
        {{--</div>--}}

        {{--{{ Form::close() }}--}}



            @include('flash::message')
            <h1><span class='glyphicon glyphicon-user'></span> Edit User</h1>

            <form class="form-horizontal" role="form" action="{{ url('/admin/'.$user->id.'/edit') }}" method="POST">
                {!! csrf_field() !!}
                <div class="form-group">
                    <label class="col-md-3 control-label">Name:</label>
                    <div class="col-md-8">
                        <input class="form-control" name="name" type="text" value="{{ old('name', $user->name)  }}">
                        @if($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name')}}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Role:</label>
                    <div class="col-md-8">
                        <select class="form-control" name="role" type="select">
                            @if($user->role_id == 1)
                                <option value="0">User</option>
                                <option value="1" selected>Admin</option>
                            @else
                                <option value="0" selected>User</option>
                                <option value="1">Admin</option>
                            @endif
                        </select>
                        @if($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name')}}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Email:</label>
                    <div class="col-md-8">
                        <input class="form-control" name="email" type="text" value="{{ old('email', $user->email)  }}">
                        @if($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email')}}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group"{{ $errors->has('password') ? ' has-error' : '' }}>
                    <label class="col-md-3 control-label">New password:</label>
                    <div class="col-md-8">
                        <input class="form-control" name="password" type="password" placeholder="Password">

                        @if ($errors->has('password'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="form-group"{{ $errors->has('password_confirmation') ? ' has-error' : '' }}>
                    <label class="col-md-3 control-label">Confirm new password:</label>
                    <div class="col-md-8">
                        <input class="form-control" name="password_confirmation" type="password" placeholder="Password">

                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"></label>
                    <div class="col-md-8">
                        <button type="submit" class="btn btn-primary">
                            Save Changes
                        </button>


                        <span></span>
                        <input type="reset" class="btn btn-default" value="Cancel">
                    </div>
                </div>
            </form>

    </div>

@stop