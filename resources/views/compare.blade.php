@extends('layouts.app')

@section('content')
<div class="banner">
    <div class="intro-overlay">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2>Comparison</h2>
                </div>
            </div>
        </div>
        <!-- /.container -->
    </div>
</div>
<!-- /.banner -->
<br/>
@if(!isset($first))
<?php var_dump($first) ?>
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
    <div class="row">
        <div class="col-lg-12">
            @component('components.compare-form')
            @endcomponent
        </div>
    </div>
</div>
@else
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
<div class="container target">
    <div class="row">
        <div class="col-md-2">
            <img title="Profile Image" class="img-circle img-responsive" src='{{ $first['analysis']->profile_image }}'>
        </div>
        <div class="col-md-2">
            <img title="Profile Image" class="img-circle img-responsive" src='{{ $second['analysis']->profile_image }}'>
        </div>
        @if(isset($third))
            <div class="col-md-2">
                <img title="Profile Image" class="img-circle img-responsive" src='{{ $third['analysis']->profile_image }}'>
            </div>
        @endif
        @if(isset($fourth))
            <div class="col-md-2">
                <img title="Profile Image" class="img-circle img-responsive" src='{{ $fourth['analysis']->profile_image }}'>
            </div>
        @endif
    </div>
    <br>
    <div class="row">
        <div class="col-sm-3">
            <!--left col-->
            <div class="row">  
                <ul class="list-group">
                    <li class="list-group-item text-muted" contenteditable="false">{{ $first['analysis']->name }}</li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Twitter ID</strong></span> {{ $first['analysis']->twitter_id }}</li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Location</strong></span> 
                        @php
                            if($first['analysis']->location != ''){
                                echo $first['analysis']->location;
                            }else{
                                echo "Unknown";
                            }
                        @endphp
                    </li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Tweets</strong></span> {{ $first['analysis']->tweets }}</li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Following</strong></span> {{ $first['analysis']->following }}</li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Followers</strong></span> {{ $first['analysis']->followers }}</li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Likes</strong></span> {{ $first['analysis']->likes }}</li>
                </ul>
            </div>
            <div class="row">  
                <ul class="list-group">
                    <li class="list-group-item text-muted" contenteditable="false">{{ $second['analysis']->name }}</li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Twitter ID</strong></span> {{ $second['analysis']->twitter_id }}</li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Location</strong></span> 
                        @php
                            if($second['analysis']->location != ''){
                                echo $second['analysis']->location;
                            }else{
                                echo "Unknown";
                            }
                        @endphp
                    </li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Tweets</strong></span> {{ $second['analysis']->tweets }}</li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Following</strong></span> {{ $second['analysis']->following }}</li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Followers</strong></span> {{ $second['analysis']->followers }}</li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Likes</strong></span> {{ $second['analysis']->likes }}</li>
                </ul>
            </div>
            @if(isset($third))
                <div class="row">  
                    <ul class="list-group">
                        <li class="list-group-item text-muted" contenteditable="false">{{ $third['analysis']->name }}</li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong class="">Twitter ID</strong></span> {{ $third['analysis']->twitter_id }}</li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong class="">Location</strong></span> 
                            @php
                                if($third['analysis']->location != ''){
                                    echo $third['analysis']->location;
                                }else{
                                    echo "Unknown";
                                }
                            @endphp
                        </li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong class="">Tweets</strong></span> {{ $third['analysis']->tweets }}</li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong class="">Following</strong></span> {{ $third['analysis']->following }}</li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong class="">Followers</strong></span> {{ $third['analysis']->followers }}</li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong class="">Likes</strong></span> {{ $third['analysis']->likes }}</li>
                    </ul>
                </div>
            @endif
            @if(isset($fourth))
                <div class="row">  
                    <ul class="list-group">
                        <li class="list-group-item text-muted" contenteditable="false">{{ $fourth['analysis']->name }}</li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong class="">Twitter ID</strong></span> {{ $fourth['analysis']->twitter_id }}</li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong class="">Location</strong></span> 
                            @php
                                if($fourth['analysis']->location != ''){
                                    echo $fourth['analysis']->location;
                                }else{
                                    echo "Unknown";
                                }
                            @endphp
                        </li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong class="">Tweets</strong></span> {{ $fourth['analysis']->tweets }}</li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong class="">Following</strong></span> {{ $fourth['analysis']->following }}</li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong class="">Followers</strong></span> {{ $fourth['analysis']->followers }}</li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong class="">Likes</strong></span> {{ $fourth['analysis']->likes }}</li>
                    </ul>
                </div>
            @endif
        </div>
        <!--/col-3-->
        <div class="col-sm-9" style="" contenteditable="false">
            <div class="panel panel-default target">
                <div class="panel-heading" contenteditable="false">Overall Positivity</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-8">
                            <canvas id="positivity" width="50" height="50"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default target">
                <div class="panel-heading" contenteditable="false">Individual Emotions</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6 align-self-center">
                            <canvas id="compare1" width="50" height="50"></canvas>
                        </div>
                        <div class="col-md-6" off>
                            <canvas id="compare2" width="50" height="50"></canvas>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 align-self-center">
                            <canvas id="compare3" width="50" height="50"></canvas>
                        </div>
                        <div class="col-md-6" off>
                            <canvas id="compare4" width="50" height="50"></canvas>
                        </div>
                    </div>
                    @php
                        $positivity = array($first['analysis']->neutral, $first['analysis']->positive, $first['analysis']->negative, $second['analysis']->neutral, $second['analysis']->positive, $second['analysis']->negative);
                        $compareNames = array($first['analysis']->name, $second['analysis']->name);
                        $compare1 = array($first['analysis']->anger, $first['analysis']->anticipation, $second['analysis']->anger, $second['analysis']->anticipation);
                        $compare2 = array($first['analysis']->disgust, $first['analysis']->fear, $second['analysis']->disgust, $second['analysis']->fear);
                        $compare3 = array($first['analysis']->joy, $first['analysis']->sadness, $second['analysis']->joy, $second['analysis']->sadness);
                        $compare4 = array($first['analysis']->surprise, $first['analysis']->trust, $second['analysis']->surprise, $second['analysis']->trust);
                        if(isset($third)){
                            array_push($positivity, $third['analysis']->neutral, $third['analysis']->positive, $third['analysis']->negative);
                            array_push($compareNames, $third['analysis']->name);
                            array_push($compare1, $third['analysis']->anger, $third['analysis']->anticipation);
                            array_push($compare2, $third['analysis']->disgust, $third['analysis']->fear);
                            array_push($compare3, $third['analysis']->joy, $third['analysis']->sadness);
                            array_push($compare4, $third['analysis']->surprise, $third['analysis']->trust);
                        }
                        if(isset($fourth)){
                            array_push($positivity, $fourth['analysis']->neutral, $fourth['analysis']->positive, $fourth['analysis']->negative);
                            array_push($compareNames, $fourth['analysis']->name);
                            array_push($compare1, $fourth['analysis']->anger, $fourth['analysis']->anticipation);
                            array_push($compare2, $fourth['analysis']->disgust, $fourth['analysis']->fear);
                            array_push($compare3, $fourth['analysis']->joy, $fourth['analysis']->sadness);
                            array_push($compare4, $fourth['analysis']->surprise, $fourth['analysis']->trust);
                        }
                    @endphp
                </div> 
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Inside Their Tweets</div>
                <div class="panel-body" id="analytics">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="percentage" id="replies" data-toggle="tooltip" title="Percent of tweets that were replies." manual="true"></div>
                        </div>
                        <div class="col-sm-3">
                            <div class="percentage" id="mentions" data-toggle="tooltip" title="Percent of tweets that had @mentions."></div>
                        </div>
                        <div class="col-sm-3">
                            <div class="percentage" id="hashtags" data-toggle="tooltip" title="Percent of tweets that have hashtags."></div>
                        </div>
                        <div class="col-sm-3">
                            <div class="percentage" id="retweets" data-toggle="tooltip" title="Percent of tweets that were retweets."></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="percentage" id="links" data-toggle="tooltip" title="Percent of tweets that contain links."></div>
                        </div>
                        <div class="col-sm-3">
                            <div class="percentage" id="media" data-toggle="tooltip" title="Percent of tweets that contains media."></div>
                        </div>
                        <div class="col-sm-3">
                            <div class="percentage" class="retweeted" id="retweeted" data-toggle="tooltip" title="Percent of tweets retweeted by others."></div>
                        </div>
                        <div class="col-sm-3">
                            <div class="percentage" id="favorited" data-toggle="tooltip" title="Percent of tweets favorited by others."></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Active Hours</div>
                <div class="panel-body">
                    @php
                        $time = array();
                        $occurs = array();
                        $time1 = array();
                        $occurs1 = array();
                        $time2 = array();
                        $occurs2 = array();
                    @endphp
                    @if(isset($first['hours']))
                        @foreach($first['hours'] as $hour)
                            @php
                                array_push($time1, $hour->hour);
                                array_push($occurs1, $hour->occurs);
                            @endphp
                        @endforeach
                        @php
                            array_push($time, $time1);
                            array_push($occurs, $occurs1);
                        @endphp
                    @endif
                    @if(isset($second['hours']))
                        @foreach($second['hours'] as $hour)
                            @php
                                array_push($time2, $hour->hour);
                                array_push($occurs2, $hour->occurs);
                            @endphp
                        @endforeach
                        @php
                            array_push($time, $time2);
                            array_push($occurs, $occurs2);
                        @endphp
                    @endif
                    <canvas id="active" width="50" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
@section('javascript')
    <script type="text/javascript">    
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    <script src="{{ asset('js/CompareCharts.js') }}"></script>
    <script type="text/javascript">
        @if (isset($positivity))
            var positivity = {{ json_encode($positivity) }}
            var comNames = <?php echo json_encode($compareNames); ?>;
            var com1 = {{ json_encode($compare1) }}
            var com2 = {{ json_encode($compare2) }}
            var com3 = {{ json_encode($compare3) }}
            var com4 = {{ json_encode($compare3) }}
            var replies = {{ ($first['analysis']->replies/$first['analysis']->total)*100 }}
            var mentions = {{ ($first['analysis']->mentions/$first['analysis']->total)*100 }}
            var hashtags = {{ ($first['analysis']->hashtags/$first['analysis']->total)*100 }}
            var retweets = {{ ($first['analysis']->retweets/$first['analysis']->total)*100 }}
            var links = {{ ($first['analysis']->links/$first['analysis']->total)*100 }}
            var media = {{ ($first['analysis']->media/$first['analysis']->total)*100 }}
            var retweeted = {{ ($first['analysis']->retweet_count/$first['analysis']->total)*100 }}
            var favorited = {{ ($first['analysis']->favorite_count/$first['analysis']->total)*100 }}
            var time = {{ json_encode($time) }}
            var occurs = {{ json_encode($occurs) }}
            
            positive("positivity", comNames, positivity);
            compare("compare1", comNames, ['Anger', 'Anticiaption'], com1);
            compare("compare2", comNames, ['Disgust', 'Fear'], com2);
            compare("compare3", comNames, ['Joy', 'Sadness'], com3);
            compare("compare4", comNames, ['Surprise', 'Trust'], com4);
            percentage("replies", "Replies", replies, false);
            percentage("mentions", "@Mentions", mentions, false);
            percentage("hashtags", "Hashtags", hashtags, false);
            percentage("retweets", "Retweets", retweets, false);
            percentage("links", "Includes Links", links, false);
            percentage("media", "Includes Media", media, false);
            percentage("retweeted", "Retweeted", retweeted, false);
            percentage("favorited", "Favorited", favorited, false);
            activeHours("active", time, occurs);
        @endif
	</script>
@endsection