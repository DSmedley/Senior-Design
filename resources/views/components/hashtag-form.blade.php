<!--Analyze Twitter User-->
<div class="panel panel-default">
    <div class="panel-heading">Analyze Hashtag</div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                Enter a hashtag about a topic of interest. We will gather the given hashtag details and the tweets related to it, analyze them and put the results into simple and easy to read charts. 
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
                <form class="form-horizontal" method="POST" action="{{ route('hashtag') }}">
                    {{ csrf_field() }}
                    
                    
                    
                    <div class="col-sm-12">
                        <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                            <div class="input-group">
                                <input id="amount" name="amount" type="text" data-slider-min="50" data-slider-max="200" data-slider-step="10" data-slider-value="100"/>
                            </div>
                            
                            <span id="ex6CurrentSliderValLabel">Tweet Amount: <span id="amountSliderVal">100</span></span>
                            
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('amount') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="col-sm-4" style="margin-right:15px;">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <div class="input-group">
                                <span class="input-group-addon" id="sizing-addon2">#</span>
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
                            <button type="submit" name="analyze" class="btn btn-primary">
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