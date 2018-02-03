@extends('layouts.app')

@section('content')
<div class="container target">
    @component('components.userHeader')
    @endcomponent
    <div class="row">
        <div class="col-sm-3">
            <!--left col-->
            <ul class="list-group">
                <li class="list-group-item text-muted" contenteditable="false">Profile</li>
                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Email</strong></span> {{ Auth::user()->email }}</li>
                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Joined</strong></span> {{ Auth::user()->created_at }}</li>
                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Last Active</strong></span> {{ Auth::user()->updated_at }}</li>
            </ul>
        </div>
        <!--/col-3-->
        <div class="col-sm-9" style="" contenteditable="false">
            <div class="panel panel-default">
                <div class="panel-heading">{{ Auth::user()->name }}'s Bio</div>
                <div class="panel-body">{{ Auth::user()->bio }}</div>
            </div>
            <div class="panel panel-default target">
                <div class="panel-heading" contenteditable="false">Saved analyses</div>
                <div class="panel-body">
                    <div class="row">
                        @foreach($analyses as $analysis)
                            <div class="col-md-4">
                                <div class="thumbnail">
                                    <!--<img alt="300x200" src="">-->
                                    <div class="caption">
                                        <canvas id="pie-chart" width="50" height="50"></canvas>
                                        <h3><a href="{{ route('analysis.view', array('id' => $analysis->id)) }}">{{$analysis->name}}</a></h3>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>      
                </div> 
            </div>
        </div>
    </div>
</div>
@endsection

