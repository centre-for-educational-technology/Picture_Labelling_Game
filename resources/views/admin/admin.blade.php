@extends('layouts.app')

@section('title') Users @stop

@section('content')

    <div class="col-lg-10 col-lg-offset-1">

        <h1><span class="glyphicon glyphicon-user"></span> User Administration</h1>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">

                <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Date/Time Added</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        @if($user->role_id == 1)
                            <td>Admin</td>
                        @else
                            <td>User</td>
                        @endif
                        <td>{{ $user->created_at->format('F d, Y h:ia') }}</td>
                        <td>
                            <a href="admin/{{ $user->id }}/edit" class="btn btn-info pull-left" style="margin-right: 3px;">Edit</a>
                            {{ Form::open(['url' => 'admin/' . $user->id, 'method' => 'DELETE']) }}
                            {{ Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                            {{ Form::close() }}
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>

        <a href="admin/create" class="btn btn-success">Add User</a>

    </div>

@stop