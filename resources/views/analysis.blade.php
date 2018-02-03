@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <!--Analyze Twitter User-->
            <div class="panel panel-default">
                <div class="panel-heading">Analyze New Twitter User</div>
                <div class="panel-body">
                    @if (session('Error'))
                        <div class="alert alert-danger">
                            {{ session('Error') }}
                        </div>
                    @endif
                    @if (session('Success'))
                        <div class="alert alert-success">
                            {{ session('Success') }}
                        </div>
                    @endif
                    <form class="form-horizontal" method="POST" action="{{ route('analyze') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <span class="input-group-addon" id="sizing-addon2">@</span>
                                    <input id="name" name="name" type="text" class="form-control" placeholder="Enter Twitter Screen Name" aria-describedby="sizing-addon2" required>
                                </div>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" name="analyze" class="btn btn-primary">
                                    Analyze
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--End Analyze Twitter User-->
        </div>
    </div>
</div>
@if(isset($analysis))
<div class="row">
    <div class="col-lg-12">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Twitter ID</th>
                    <th>Name</th>
                    <th>Screen Name</th>
                    <th>Location</th>
                    <th>URL</th>
                    <th>Description</th>
                    <th>Tweets</th>
                    <th>Following</th>
                    <th>Followers</th>
                    <th>Likes</th>
                    <th>Created</th>
                    <th>Updated</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$analysis->id}}</td>
                    <td>{{$analysis->twitter_id}}</td>
                    <td>{{$analysis->name}}</td>
                    <td>{{$analysis->screen_name}}</td>
                    <td>{{$analysis->location}}</td>
                    <td>{{$analysis->url}}</td>
                    <td>{{$analysis->description}}</td>
                    <td>{{$analysis->tweets}}</td>
                    <td>{{$analysis->following}}</td>
                    <td>{{$analysis->followers}}</td>
                    <td>{{$analysis->likes}}</td>
                    <td>{{$analysis->created_at}}</td>
                    <td>{{$analysis->updated_at}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection
