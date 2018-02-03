@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            @component('components.analyze')
            @endcomponent
        </div>
    </div>
</div>
@if(isset($analysis))
<div class="container target">
    <div class="row">
        <div class="col-sm-10">
            <h1>{{ $analysis->name }}</h1>
            <h3>{{ "@".$analysis->screen_name }}</h3>
            <br>
        </div>
        <div class="col-sm-2">
            <img title="Profile Image" class="img-circle img-responsive" src='{{ $analysis->url }}'>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-3">
            <!--left col-->
            <ul class="list-group">
                <li class="list-group-item text-muted" contenteditable="false">Analysis</li>
                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Twitter ID</strong></span> {{ $analysis->twitter_id }}</li>
                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Location</strong></span> {{ $analysis->location }}</li>
                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Tweets</strong></span> {{ $analysis->tweets }}</li>
                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Following</strong></span> {{ $analysis->following }}</li>
                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Followers</strong></span> {{ $analysis->followers }}</li>
                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Likes</strong></span> {{ $analysis->likes }}</li>
            </ul>
        </div>
        <!--/col-3-->
        <div class="col-sm-9" style="" contenteditable="false">
            <div class="panel panel-default">
                <div class="panel-heading">Description</div>
                <div class="panel-body">{{ $analysis->description }}</div>
            </div>
            <div class="panel panel-default target">
                <div class="panel-heading" contenteditable="false">Results</div>
                <div class="panel-body">    
                </div> 
            </div>
        </div>
    </div>
</div>
@endif
@endsection
