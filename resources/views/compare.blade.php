@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
</div>
@if(isset($first))
@if(isset($second))
<div class="container target">
    <div class="row">
        <div class="col-lg-2">
            <img title="Profile Image" class="img-circle img-responsive" src='{{ $first->profile_image }}'>
        </div>
        <div class="col-lg-2">
            <img title="Profile Image" class="img-circle img-responsive" src='{{ $second->profile_image }}'>
        </div>
        @if(isset($third))
            <div class="col-lg-2">
                <img title="Profile Image" class="img-circle img-responsive" src='{{ $third->profile_image }}'>
            </div>
        @endif
        @if(isset($fourth))
            <div class="col-lg-2">
                <img title="Profile Image" class="img-circle img-responsive" src='{{ $fourth->profile_image }}'>
            </div>
        @endif
    </div>
    <br>
    <div class="row">
        <div class="col-sm-3">
            <!--left col-->
            <div class="row">  
                <ul class="list-group">
                    <li class="list-group-item text-muted" contenteditable="false">{{ $first->name }}</li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Twitter ID</strong></span> {{ $first->twitter_id }}</li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Location</strong></span> 
                        @php
                            if($first->location != ''){
                                echo $first->location;
                            }else{
                                echo "Unknown";
                            }
                        @endphp
                    </li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Tweets</strong></span> {{ $first->tweets }}</li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Following</strong></span> {{ $first->following }}</li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Followers</strong></span> {{ $first->followers }}</li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Likes</strong></span> {{ $first->likes }}</li>
                </ul>
            </div>
            <div class="row">  
                <ul class="list-group">
                    <li class="list-group-item text-muted" contenteditable="false">{{ $second->name }}</li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Twitter ID</strong></span> {{ $second->twitter_id }}</li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Location</strong></span> 
                        @php
                            if($second->location != ''){
                                echo $second->location;
                            }else{
                                echo "Unknown";
                            }
                        @endphp
                    </li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Tweets</strong></span> {{ $second->tweets }}</li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Following</strong></span> {{ $second->following }}</li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Followers</strong></span> {{ $second->followers }}</li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Likes</strong></span> {{ $second->likes }}</li>
                </ul>
            </div>
            @if(isset($third))
                <div class="row">  
                    <ul class="list-group">
                        <li class="list-group-item text-muted" contenteditable="false">{{ $third->name }}</li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong class="">Twitter ID</strong></span> {{ $third->twitter_id }}</li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong class="">Location</strong></span> 
                            @php
                                if($third->location != ''){
                                    echo $third->location;
                                }else{
                                    echo "Unknown";
                                }
                            @endphp
                        </li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong class="">Tweets</strong></span> {{ $third->tweets }}</li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong class="">Following</strong></span> {{ $third->following }}</li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong class="">Followers</strong></span> {{ $third->followers }}</li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong class="">Likes</strong></span> {{ $third->likes }}</li>
                    </ul>
                </div>
            @endif
            @if(isset($fourth))
                <div class="row">  
                    <ul class="list-group">
                        <li class="list-group-item text-muted" contenteditable="false">{{ $fourth->name }}</li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong class="">Twitter ID</strong></span> {{ $fourth->twitter_id }}</li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong class="">Location</strong></span> 
                            @php
                                if($fourth->location != ''){
                                    echo $fourth->location;
                                }else{
                                    echo "Unknown";
                                }
                            @endphp
                        </li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong class="">Tweets</strong></span> {{ $fourth->tweets }}</li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong class="">Following</strong></span> {{ $fourth->following }}</li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong class="">Followers</strong></span> {{ $fourth->followers }}</li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong class="">Likes</strong></span> {{ $fourth->likes }}</li>
                    </ul>
                </div>
            @endif
        </div>
        <!--/col-3-->
        <div class="col-sm-9" style="" contenteditable="false">
            <div class="panel panel-default target">
                <div class="panel-heading" contenteditable="false">Results</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-8 align-self-center" off>
                            <canvas id="positivity" width="50" height="50"></canvas>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 align-self-center" off>
                            <canvas id="compare1" width="50" height="50"></canvas>
                        </div>
                        <div class="col-md-6" off>
                            <canvas id="compare2" width="50" height="50"></canvas>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 align-self-center" off>
                            <canvas id="compare3" width="50" height="50"></canvas>
                        </div>
                        <div class="col-md-6" off>
                            <canvas id="compare4" width="50" height="50"></canvas>
                        </div>
                    </div>
                    @php
                        $positivity[] = array($first->neutral, $first->positive, $first->negative, $second->neutral, $second->positive, $second->negative);
                        $compareNames[] = array($first->name, $second->name);
                        $compare1[] = array($first->anger, $first->anticipation, $second->anger, $second->anticipation);
                        $compare2[] = array($first->disgust, $first->fear, $second->disgust, $second->fear);
                        $compare3[] = array($first->joy, $first->sadness, $second->joy, $second->sadness);
                        $compare4[] = array($first->surprise, $first->trust, $second->surprise, $second->trust);
                        $emotions[] = array($first->anger, $first->anticipation, $first->disgust, $first->fear, $first->joy, $first->sadness, $first->surprise, $first->trust);
                    @endphp
                </div> 
            </div>
        </div>
    </div>
</div>
@else
    <div class="alert alert-danger">
        There is a minimum of two users required to complete a comparison!
    </div>
@endif
@else
    <div class="alert alert-danger">
        An error has occured!
    </div>
@endif
@endsection
@section('javascript')
    <script src="{{ asset('js/CompareCharts.js') }}"></script>
    <script type="text/javascript">
        @if (isset($positivity))
            var positivity = {{ json_encode($positivity) }}
            var comNames = <?php echo json_encode($compareNames); ?>;
            var com1 = {{ json_encode($compare1) }}
            var com2 = {{ json_encode($compare2) }}
            var com3 = {{ json_encode($compare3) }}
            var com4 = {{ json_encode($compare3) }}
            positive("positivity", comNames[0], positivity[0]);
            compare("compare1", comNames[0], ['Anger', 'Anticiaption'], com1[0]);
            compare("compare2", comNames[0], ['Disgust', 'Fear'], com2[0]);
            compare("compare3", comNames[0], ['Joy', 'Sadness'], com3[0]);
            compare("compare4", comNames[0], ['Surprise', 'Trust'], com4[0]);
        @endif
	</script>
@endsection