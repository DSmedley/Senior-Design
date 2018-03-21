<!--Analyze Twitter User-->
<div class="panel panel-default">
    <div class="panel-heading">New Analysis</div>
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
        <form class="form-horizontal" method="POST" action="{{ route('analyze') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <div class="col-sm-4">
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
            <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                <div class="col-sm-4">
                    <div class="input-group">
                        <input id="amount" name="amount" type="text" data-slider-min="50" data-slider-max="200" data-slider-step="10" data-slider-value="100"/>
                    </div>

                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('amount') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            
            <span id="ex6CurrentSliderValLabel">Tweet Amount: <span id="amountSliderVal">100</span></span>

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