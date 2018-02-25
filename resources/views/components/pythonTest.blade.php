<!--Python Script Caller-->
<div class="panel panel-default">
    <div class="panel-heading">Call A Python Script!</div>
    <div class="panel-body">
        @if (session('pythonError'))
            <div class="alert alert-danger">
                {{ session('pythonError') }}
            </div>
        @endif
        @if (session('pythonSuccess'))
            <div class="alert alert-success">
                {{ session('pythonSuccess') }}
            </div>
        @endif
        <form class="form-horizontal" method="POST" action="{{ route('python') }}">
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
                    <button type="submit" name="python" class="btn btn-primary">
                        Run Python
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<!--End Python Script Caller-->