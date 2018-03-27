<!--Analyze Twitter User-->
<div class="panel panel-default">
    <div class="panel-heading">New Analysis</div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                Enter friends, competitors, employee candidates or industry leaders. We will gather the given user details and latest tweets, analyze them and put them into simple and easy to read charts. 
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
                <form class="form-horizontal" method="POST" action="{{ route('analyze') }}">
                    {{ csrf_field() }}
                    
                    <div class="col-sm-4" style="margin-right:15px;">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <div class="input-group">
                                <span class="input-group-addon" id="sizing-addon2">@</span>
                                <input id="name" name="name" type="text" class="form-control" placeholder="Enter Twitter Screen Name" aria-describedby="sizing-addon2">
                            </div>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <button type="submit" id="analyzeButton" data-loading-text="Loading..." name="analyze" class="btn btn-primary">
                                Analyze
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
<!--End Analyze Twitter User-->