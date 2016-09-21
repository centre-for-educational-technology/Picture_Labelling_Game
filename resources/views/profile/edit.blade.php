@extends('layouts.app')


@section('content')




    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @include('flash::message')

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1>Personal info</h1>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" action="{{ url('user/edit') }}" method="POST">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label class="col-md-3 control-label">Old password:</label>
                                <div class="col-md-8">
                                    <input class="form-control" name="old_password" type="password" placeholder="Password">
                                    @if($errors->has('old_password'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('old_password')}}</strong>
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
                </div>

            </div>
        </div>
    </div>
@endsection