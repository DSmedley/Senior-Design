@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h2>ADMIN DASHBOARD</h2>   
    </div>
</div>              
<!-- /. ROW  -->
<hr />
<div class="row">
    <div class="col-lg-12 ">
        <div class="alert alert-info">
            <strong>Welcome {{ Auth::user()->name }}!</strong>
        </div>
    </div>
</div>
<!-- /. ROW  --> 
<div class="row text-center pad-top">
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
        <div class="div-square">
            <a href="{{ route('admin.settings') }}" >
                <i class="fas fa-cog fa-5x"></i>
                <h4>Site Settings</h4>
            </a>
        </div>
    </div> 
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
        <div class="div-square">
            <a href="{{ route('admin.users') }}" >
                <i class="fas fa-users fa-5x"></i>
                <h4>Manage Users</h4>
            </a>
        </div>
    </div>
</div>
@endsection