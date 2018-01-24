<div class="row">
    <div class="col-sm-10">
        <h1 class="">{{ Auth::user()->name }} </h1>
        <a href="{{ route('user.inbox') }}"><button type="button" class="btn btn-success"><i class="fas fa-envelope"> Inbox</i></button></a>
        <a href="{{ route('user.edit') }}"><button type="button" class="btn btn-info"><i class="fas fa-cog"> Edit Profile</i></button></a>
        <a href="{{ route('user') }}"><button type="button" class="btn btn-info"><i class="fas fa-tasks"> View Profile</i></button></a>
        <br>
    </div>
    <div class="col-sm-2">
        <img title="Profile Image" class="img-circle img-responsive" src='/uploads/avatars/{{ Auth::user()->avatar }}'>
    </div>
</div>
<br>