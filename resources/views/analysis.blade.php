@extends('layouts.app')

@section('content')
<div class="banner">
    <div class="intro-overlay">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2>Analysis</h2>
                </div>
            </div>
        </div>
        <!-- /.container -->
    </div>
</div>
<!-- /.banner -->
<br/>
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
            @component('components.analyze')
            @endcomponent
        </div>
    </div>
</div>
@if(isset($analysis))
<div class="container target">
    <div class="row">
        <div class="col-sm-10">
            <h1>
                {{ $analysis->name }}
                @if($analysis->verified)
                    <i class="fas fa-check-circle verified"></i>
                @endif
            </h1>
            <h3>{{ "@".$analysis->screen_name }}</h3>
            @guest
                <a href="{{ route('analysis.save', array('id' => $analysis->id)) }}"><button type="button" class="btn btn-success"><i class="fas fa-save"> Login to save</i></button></a>
            @endguest
            <br>
        </div>
        <div class="col-sm-2">
            <img title="Profile Image" class="img-circle img-responsive" src='{{ $analysis->profile_image }}'>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-3">
            <!--left col-->
            <ul class="list-group">
                <li class="list-group-item text-muted" contenteditable="false">Analysis</li>
                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Twitter ID</strong></span> {{ $analysis->twitter_id }}</li>
                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Location</strong></span> 
                    @php
                        if($analysis->location != ''){
                            echo $analysis->location;
                        }else{
                            echo "Unknown";
                        }
                    @endphp
                </li>
                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Tweets</strong></span> {{ $analysis->tweets }}</li>
                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Following</strong></span> {{ $analysis->following }}</li>
                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Followers</strong></span> {{ $analysis->followers }}</li>
                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Likes</strong></span> {{ $analysis->likes }}</li>
                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Join Date</strong></span> {{ $analysis->joined }}</li>
                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Time Zone</strong></span> {{ $analysis->time_zone }}</li>
                <li class="list-group-item text-right"><span class="pull-left"><strong class="">URL</strong></span><a href="{{ $analysis->url }}" target="_blank">{{ $analysis->url }}</a></li>
            </ul>
        </div>
        <!--/col-3-->
        <div class="col-sm-9" style="" contenteditable="false">
            <div class="panel panel-default">
                <div class="panel-heading">Description</div>
                <div class="panel-body">
                    @php
                        if($analysis->description != ''){
                            echo $analysis->description;
                        }else{
                            echo "No description.";
                        }
                    @endphp
                </div>
            </div>
            <div class="panel panel-default target">
                <div class="panel-heading" contenteditable="false">Results</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4 align-self-center" off>
                            <canvas id="positivity" width="50" height="50"></canvas>
                        </div>
                        <div class="col-md-8" off>
                            <canvas id="emotions" width="50" height="50"></canvas>
                        </div>
                    </div>
                    @php
                        $positivity = array($analysis->neutral, $analysis->positive, $analysis->negative);
                        $emotions = array($analysis->anger, $analysis->anticipation, $analysis->disgust, $analysis->fear, $analysis->joy, $analysis->sadness, $analysis->surprise, $analysis->trust);
                    @endphp
                </div> 
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">How They Tweet</div>
                <div class="panel-body">
                    Replies	- {{ $analysis->replies }} / {{ $analysis->total }} <br />
                    Tweets with @mentions - {{ $analysis->mentions }} / {{ $analysis->total }} <br />
                    Tweets with #hashtags - {{ $analysis->hashtags }} / {{ $analysis->total }} <br />
                    Retweets - {{ $analysis->retweets }} / {{ $analysis->total }} <br />
                    Tweets with links - {{ $analysis->links }} / {{ $analysis->total }} <br />
                    Tweets with media - {{ $analysis->media }} / {{ $analysis->total }} <br />
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">URLs Linked</div>
                <div class="panel-body">
                    @if(isset($urls))
                        @foreach($urls as $url)
                            <a href="{{$url->url}}" target="_blank" data-toggle="tooltip" title="Used {{$url->occurs}} times">{{ ' '.$url->url.' ' }}</a>
                        @endforeach
                    @else
                        {{ $analysis->name }} did not link any URLs!
                    @endif
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Most used Hashtags</div>
                <div class="panel-body">
                    @if(isset($hashtags))
                        @foreach($hashtags as $hashtag)
                            <a href="http://twitter.com/#!/search/%23{{$hashtag->hashtag}}" target="_blank" data-toggle="tooltip" title="Used {{$hashtag->occurs}} times">{{ '#'.$hashtag->hashtag.' ' }}</a>
                        @endforeach
                    @else
                        {{ $analysis->name }} did not use any hashtags!
                    @endif
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Twitter User Mentions</div>
                <div class="panel-body">
                    <div class="container-fluid">
                        <div class="row no-gutter popup-gallery">
                            @if(isset($mentions))
                                @foreach($mentions as $mention)
                                    <div class="col-sm-4 col-md-2">
                                        <a href="{{ route('analysis', array('id' => $mention->screen_name)) }}" class="portfolio-box">
                                            <img src="{{ $mention->profile_image }}" class="img-responsive" alt="">
                                            <div class="portfolio-box-caption">
                                                <div class="portfolio-box-caption-content">
                                                    <div class="project-category text-faded">
                                                        {{"@".$mention->screen_name}}
                                                    </div>
                                                    <div class="project-name">
                                                        {{$mention->occurs}}
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            @else
                                {{ $analysis->name }} did not mention anyone!
                            @endif
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
                    @endphp
                    @if(isset($hours))
                        @foreach($hours as $hour)
                            @php
                                array_push($time, $hour->hour);
                                array_push($occurs, $hour->occurs);
                            @endphp
                        @endforeach
                    @endif
                    <canvas id="active" width="50" height="50"></canvas>
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
    <script src="{{ asset('js/ReportCharts.js') }}"></script>
    <script type="text/javascript">
        @if (isset($positivity))
            var positivity = {{ json_encode($positivity) }}
            var emotions = {{ json_encode($emotions) }}
            var time = {{ json_encode($time) }}
            var occurs = {{ json_encode($occurs) }}
            chart("positivity", positivity);
            bar("emotions", emotions);
            activeHours("active", time, occurs);
        @endif
	</script>
@endsection
