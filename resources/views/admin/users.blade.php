@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h2>MANAGE USERS</h2>
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
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                @if(count($users) > 0)
                    @foreach($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->bio}}</td>
                            <td>{{$user->created_at}}</td>
                            <td>{{$user->updated_at}}</td>
                            <td>
                                <a href="{{ route('admin.user.edit', array('id' => $user->id)) }}"> <button type="button" class="btn btn-danger"><span class="fas fa-pencil-alt"></span> Edit</button></a>
                                @if($user->blocked)
                                    <a href="{{ route('admin.user.unban', array('id' => $user->id)) }}"> <button type="button" id="unbanUserButton" class="btn btn-success"><span class="fas fa-unlock"></span> Unban</button></a>
                                @else
                                    <a href="{{ route('admin.user.ban', array('id' => $user->id)) }}"> <button type="button" id="banUserButton" class="btn btn-danger"><span class="fas fa-lock"></span> Ban</button></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

@endsection
@section('javascript')
    <script src="{{ asset('js/adminAlerts.js')}}"></script>
@endsection
