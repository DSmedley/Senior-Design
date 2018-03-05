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
                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Joined</strong></span> {{ date_format(Auth::user()->created_at, 'm/d/Y') }}</li>
                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Last Active</strong></span> {{ date_format(Auth::user()->updated_at, 'm/d/Y') }}</li>
            </ul>
        </div>
        <!--/col-3-->
        <div class="col-sm-9" style="" contenteditable="false">
            <div class="panel panel-default">
                <div class="panel-heading">{{ Auth::user()->name }}'s Bio</div>
                <div class="panel-body">
                    @if(isset(Auth::user()->bio))
                    {{ Auth::user()->bio }}
                    @else
                        Bio is empty
                    @endif
                </div>
            </div>
            <div class="panel panel-default target">
                <div class="panel-heading" contenteditable="false">Saved analyses</div>
                <div class="panel-body">
                    @php
                        $count = 0;
                        $charts = array();
                    @endphp
                    @if(isset($analyses['0']['name']))
                        {{ $analyses->links() }}
                        <div class="row">
                            @foreach($analyses as $analysis)
                                <div class="col-md-4">
                                    <div class="thumbnail">
                                        <!--<img alt="300x200" src="">-->
                                        <div class="caption">
                                            <canvas id="{{ "Chart".$count }}" width="50" height="50"></canvas>
                                            <h3><a href="{{ route('analysis.view', array('id' => $analysis->id)) }}">{{$analysis->name}}</a></h3>
                                            <h3>{{ date_format($analysis->created_at, 'd/m/Y H:i:s') }}</h3>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $charts[] = array($analysis->neutral, $analysis->positive, $analysis->negative);
                                    $count  += 1;
                                @endphp
                                @if($count % 3 == 0)
                                    </div>
                                    <div class="row">
                                @endif
                            @endforeach
                        </div> 
                        {{ $analyses->links() }}
                    @else
                        You have no saved Analyses!
                    @endif
                </div> 
            </div>
        </div>
    </div>
</div>
@endsection
@section('javascript')
    <script src="{{ asset('js/ReportCharts.js') }}"></script>
    <script type="text/javascript">
        var charts = {{ json_encode($charts) }}
        
        for (var i = 0; i < charts.length; i++) {
		  preview("Chart"+i, charts[i]);
        }
	</script>
@endsection
