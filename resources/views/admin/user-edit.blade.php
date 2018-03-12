@extends('layouts.admin')

@section('content')
@if(isset($user))
    <div class="row">
        <div class="col-lg-12">
            <h2>MANAGING: {{$user->name}}</h2>   
        </div>
    </div>              
    <!-- /. ROW  -->
    <hr />
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Bio</th>
                        <th>Created</th>
                        <th>Updated</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$user->id}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->bio}}</td>
                        <td>{{$user->created_at}}</td>
                        <td>{{$user->updated_at}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <!--Change Password-->
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>
                <div class="panel-body">
                    @if (session('passwordError'))
                        <div class="alert alert-danger">
                            {{ session('passwordError') }}
                        </div>
                    @endif
                        @if (session('passwordSuccess'))
                            <div class="alert alert-success">
                                {{ session('passwordSuccess') }}
                            </div>
                        @endif
                    <form class="form-horizontal" method="POST" action="{{ route('admin.user.edit', array('id' => $user->id)) }}" id="changePassword">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                            <div class="col-lg-12">
                                <input id="new-password" type="password" class="form-control" name="new-password" placeholder="New Password" required>

                                @if ($errors->has('new-password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('new-password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-12">
                                <input id="new-password-confirm" type="password" class="form-control" name="new-password_confirmation" placeholder="Confirm Password" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 col-md-offset-3">
                                <button type="button" id="changePasswordButton" class="btn btn-primary">
                                    Change Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--End Change Password-->
            <!--Change Username-->
            <div class="panel panel-default">
                <div class="panel-heading">Change Name</div>
                <div class="panel-body">
                    @if (session('nameError'))
                        <div class="alert alert-danger">
                            {{ session('nameError') }}
                        </div>
                    @endif
                    @if (session('nameSuccess'))
                        <div class="alert alert-success">
                            {{ session('nameSuccess') }}
                        </div>
                    @endif
                    <form class="form-horizontal" method="POST" action="{{ route('admin.user.edit', array('id' => $user->id)) }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <div class="col-lg-12">
                                <input id="name" type="text" class="form-control" name="name" placeholder="Enter New Name" required>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 col-md-offset-3">
                                <button type="submit" name="changeName" class="btn btn-primary">
                                    Change Name
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--End Change Username-->
        </div>
        <div class="col-sm-4">
            <!--Change Email-->
            <div class="panel panel-default">
                <div class="panel-heading">Change Email</div>
                <div class="panel-body">
                    @if (session('emailError'))
                        <div class="alert alert-danger">
                            {{ session('emailError') }}
                        </div>
                    @endif
                    @if (session('emailSuccess'))
                        <div class="alert alert-success">
                            {{ session('emailSuccess') }}
                        </div>
                    @endif
                    <form class="form-horizontal" method="POST" action="{{ route('admin.user.edit', array('id' => $user->id)) }}" id="changeEmail">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-lg-12">
                                <input id="email" type="email" class="form-control" name="email" placeholder="New Email" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-12">
                                <input id="email-confirm" type="email" class="form-control" name="email_confirmation" placeholder="Confirm Email" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 col-md-offset-3">
                                <button type="button" id="changeEmailButton" class="btn btn-primary">
                                    Change Email
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--End Change Email-->
            <!--Change Bio-->
            <div class="panel panel-default">
                <div class="panel-heading">Change Bio</div>
                <div class="panel-body">
                    @if (session('bioError'))
                        <div class="alert alert-danger">
                            {{ session('bioError') }}
                        </div>
                    @endif
                    @if (session('bioSuccess'))
                        <div class="alert alert-success">
                            {{ session('bioSuccess') }}
                        </div>
                    @endif
                    <form class="form-horizontal" method="POST" action="{{ route('admin.user.edit', array('id' => $user->id)) }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('bio') ? ' has-error' : '' }}">
                            <div class="col-lg-12">
                                <textarea id="bio" class="form-control" name="bio" placeholder="Enter Bio" required></textarea>

                                @if ($errors->has('bio'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('bio') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 col-md-offset-3">
                                <button type="submit" name="changeBio" class="btn btn-primary">
                                    Change Bio
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--End Change Bio-->
        </div>
        <div class="col-sm-4">
            <!--Change Avatar-->
            <div class="panel panel-default">
                <div class="panel-heading">Change Avatar</div>
                <div class="panel-body">
                    @if (session('avatarError'))
                        <div class="alert alert-danger">
                            {{ session('avatarError') }}
                        </div>
                    @endif
                    @if (session('avatarSuccess'))
                        <div class="alert alert-success">
                            {{ session('avatarSuccess') }}
                        </div>
                    @endif
                    <form enctype="multipart/form-data" action="{{ route('admin.user.edit', array('id' => $user->id)) }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="file" name="avatar" class="btn btn-default">
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 col-md-offset-3">
                                <button type="submit" name="changeAvatar" class="btn btn-primary">
                                    Change Avatar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--End Change Avatar-->
            <!--Change Avatar-->
            <div class="panel panel-default">
                <div class="panel-heading">Administrator Rights</div>
                <div class="panel-body">
                    @if (session('adminError'))
                        <div class="alert alert-danger">
                            {{ session('adminError') }}
                        </div>
                    @endif
                    @if (session('adminSuccess'))
                        <div class="alert alert-success">
                            {{ session('adminSuccess') }}
                        </div>
                    @endif
                    <form enctype="multipart/form-data" action="{{ route('admin.user.edit', array('id' => $user->id)) }}" method="POST">
                        {{ csrf_field() }}
                        
                        <div class="alert alert-warning">
                            By granting a user administrative rights, they will have the ability to access the admin panel and any of its components. Only grant administrative rights to trusted users.
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-12 col-md-offset-3">
                                @if($user->is_admin)
                                <button type="submit" name="removeAdmin" class="btn btn-primary">
                                    Remove Admin
                                </button>
                                @else
                                <button type="submit" name="grantAdmin" class="btn btn-primary">
                                    Grant Admin
                                </button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--End Change Avatar-->
        </div>
    </div>
@else
    <div class="alert alert-danger">
        No user exists with that ID! 
    </div>
@endif

@endsection
@section('javascript')
    <script src="{{ asset('js/adminAlerts.js')}}"></script>
@endsection