<div class="row">
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="col-sm-10">
        <h1 class="">{{ Auth::user()->name }} </h1>
        @if(\Request::is('user'))
            <a href="{{ route('user.edit') }}"><button type="button" class="btn btn-info"><i class="fas fa-cog"> Edit Profile</i></button></a>
        @else
            <a href="{{ route('user') }}"><button type="button" class="btn btn-info"><i class="fas fa-tasks"> View Profile</i></button></a>
        @endif
        <br>
    </div>
    <div class="col-sm-2">
        <img title="Profile Image" class="img-circle img-responsive" src='/uploads/avatars/{{ Auth::user()->avatar }}'>
    </div>
</div>
<br>