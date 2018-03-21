<!--Compare Twitter Users-->
<div class="panel panel-default">
    <div class="panel-heading">Compare Twitter Users</div>
    <div class="panel-body">
        @if (session('twitterError'))
            <div class="alert alert-danger">
                {{ session('twitterError') }}
            </div>
        @endif
        @if (session('twitterSuccess'))
            <div class="alert alert-success">
                {{ session('twitterSuccess') }}
            </div>
        @endif
        <form class="form-horizontal" method="POST" action="{{ route('compare') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <div class="col-sm-4">
                    <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon2">@</span>
                        <input id="name1" name="name1" type="text" class="form-control" placeholder="Enter Twitter Screen Name" aria-describedby="sizing-addon2">
                    </div>

                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <div class="col-sm-4">
                    <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon2">@</span>
                        <input id="name2" name="name2" type="text" class="form-control" placeholder="Enter Twitter Screen Name" aria-describedby="sizing-addon2">
                    </div>

                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <div class="col-sm-4">
                    <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon2">@</span>
                        <input id="name3" name="name3" type="text" class="form-control" placeholder="Enter Twitter Screen Name" aria-describedby="sizing-addon2">
                    </div>

                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <div class="col-sm-4">
                    <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon2">@</span>
                        <input id="name4" name="name4" type="text" class="form-control" placeholder="Enter Twitter Screen Name" aria-describedby="sizing-addon2">
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
                        Compare
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<!--End Compare Twitter Users-->