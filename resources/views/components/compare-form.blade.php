<!--Compare Twitter Users-->
<div class="panel panel-default">
    <div class="panel-heading">Compare Twitter Users</div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                Enter up to four friends, competitors, employee candidates or industry leaders. We will gather the given user details and latest tweets, analyze them and put them into simple and easy to read charts. 
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
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

                    <div class="col-sm-2" style="margin-right:15px;">
                        <div class="form-group{{ $errors->has('name1') ? ' has-error' : '' }}">
                            <div class="input-group">
                                <span class="input-group-addon" id="sizing-addon2">@</span>
                                <input id="name1" name="name1" type="text" class="form-control" placeholder="Twitter Name" aria-describedby="sizing-addon2">
                            </div>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name1') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-2" style="margin-right:15px;">
                        <div class="form-group{{ $errors->has('name2') ? ' has-error' : '' }}">    
                            <div class="input-group">
                                <span class="input-group-addon" id="sizing-addon2">@</span>
                                <input id="name2" name="name2" type="text" class="form-control" placeholder="Twitter Name" aria-describedby="sizing-addon2">
                            </div>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name2') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-2" style="margin-right:15px;">
                        <div class="form-group{{ $errors->has('name3') ? ' has-error' : '' }}">    
                            <div class="input-group">
                                <span class="input-group-addon" id="sizing-addon2">@</span>
                                <input id="name3" name="name3" type="text" class="form-control" placeholder="Twitter Name" aria-describedby="sizing-addon2">
                            </div>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name3') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-2" style="margin-right:15px;">
                        <div class="form-group{{ $errors->has('name4') ? ' has-error' : '' }}">
                            <div class="input-group">
                                <span class="input-group-addon" id="sizing-addon2">@</span>
                                <input id="name4" name="name4" type="text" class="form-control" placeholder="Twitter Name" aria-describedby="sizing-addon2">
                            </div>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name4') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">    
                            <button type="submit" id="analyzeButton" data-loading-text="Loading..." name="analyze" class="btn btn-primary">
                                Compare
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <b>Note:</b> This may take up to a minute to complete the analysis.
            </div>
        </div>
    </div>
</div>
<!--End Compare Twitter Users-->