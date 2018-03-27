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
@if(!isset($analysis))
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
@else
<div class="container target">
    <div class="row">
        <div class="col-sm-10">
            <div class="sharethis-inline-share-buttons"></div>
            <h1>
                {{ $analysis->name }}
                @if($analysis->verified)
                    <i class="fas fa-check-circle verified"></i>
                @endif
            </h1>
            <h3>{{ "@".$analysis->screen_name }}</h3>
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
                <li class="list-group-item text-muted" contenteditable="false">Details</li>
                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Twitter ID</strong></span> {{ $analysis->twitter_id }}</li>
                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Location</strong></span> 
                    @if($analysis->location != null)
                        {{$analysis->location}}
                    @else
                        Unknown
                    @endif
                </li>
                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Tweets</strong></span> {{ $analysis->tweets }}</li>
                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Following</strong></span> {{ $analysis->following }}</li>
                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Followers</strong></span> {{ $analysis->followers }}</li>
                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Likes</strong></span> {{ $analysis->likes }}</li>
                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Join Date</strong></span> 
                    @php $d = new DateTime($analysis->joined);
                        echo $d->format('D M j Y'); 
                    @endphp
                </li>
                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Time Zone</strong></span>
                    @if($analysis->time_zone != null)
                        {{$analysis->time_zone}}
                    @else
                        Unknown
                    @endif
                </li>
                <li class="list-group-item text-right"><span class="pull-left"><strong class="">URL</strong></span>
                    @if($analysis->url != null)
                        <a href="{{ $analysis->url }}" target="_blank">{{ $analysis->url }}</a>
                    @else
                        No URL
                    @endif
                </li>
            </ul>
            @guest
                <a href="{{ route('analysis.save', array('id' => $analysis->id)) }}"><button type="button" class="btn btn-success"><i class="fas fa-save"> Login to save</i></button></a>
            @endguest
        </div>
        <!--/col-3-->
        <div class="col-sm-9" style="" contenteditable="false">
            <div class="panel panel-default">
                <div class="panel-heading">Description</div>
                <div class="panel-body">
                    @if($analysis->description != null)
                        {{$analysis->description}}
                    @else
                        No Description.
                    @endif
                </div>
            </div>
            <div class="panel panel-default target">
                <div class="panel-heading" contenteditable="false">Sentiment</div>
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
                <div class="panel-heading">Inside Their Tweets</div>
                <div class="panel-body" id="analytics">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="percentage" id="replies" data-toggle="tooltip" title="Percent of tweets that were replies out of {{ $analysis->total }}" manual="true"></div>
                        </div>
                        <div class="col-sm-3">
                            <div class="percentage" id="mentions" data-toggle="tooltip" title="Percent of tweets that had @mentions out of {{ $analysis->total }}"></div>
                        </div>
                        <div class="col-sm-3">
                            <div class="percentage" id="hashtags" data-toggle="tooltip" title="Percent of tweets that have hashtags out of {{ $analysis->total }}"></div>
                        </div>
                        <div class="col-sm-3">
                            <div class="percentage" id="retweets" data-toggle="tooltip" title="Percent of tweets that were retweets out of {{ $analysis->total }}"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="percentage" id="links" data-toggle="tooltip" title="Percent of tweets that contain links out of {{ $analysis->total }}"></div>
                        </div>
                        <div class="col-sm-3">
                            <div class="percentage" id="media" data-toggle="tooltip" title="Percent of tweets that contains media out of {{ $analysis->total }}"></div>
                        </div>
                        <div class="col-sm-3">
                            <div class="percentage" class="retweeted" id="retweeted" data-toggle="tooltip" title="Percent of tweets retweeted by others out of {{ $analysis->total }} with {{ number_format($analysis->retweet_total) }} total retweets."></div>
                        </div>
                        <div class="col-sm-3">
                            <div class="percentage" id="favorited" data-toggle="tooltip" title="Percent of tweets favorited by others out of {{ $analysis->total }} with {{ number_format($analysis->favorite_total) }} total favorites."></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">URLs Linked</div>
                <div class="panel-body">
                    @if(isset($urls))
                        @foreach($urls as $url)
                            <a href="{{$url->url}}" target="_blank" data-toggle="tooltip" title="Used {{$url->occurs}} times">{{ ' '.$url->url.' ' }}</a> &bull;
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
                            <a href="http://twitter.com/#!/search/%23{{$hashtag->hashtag}}" target="_blank" data-toggle="tooltip" title="Used {{$hashtag->occurs}} times">{{ '#'.$hashtag->hashtag.' ' }}</a> &bull;
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
                                        <a href="{{ route('analysis.name', array('name' => $mention->screen_name)) }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('analysis-form-{{ $mention->screen_name }}').submit();" class="portfolio-box">

                                        
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
                                        <form id="analysis-form-{{ $mention->screen_name }}" action="{{ route('analyze') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                            <input id="name" name="name" type="text" value="{{ $mention->screen_name }}">
                                        </form>
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
    <script src="{{ asset('js/ReportCharts.js') }}"></script>
    <script type="text/javascript">
        @if (isset($positivity))
            var positivity = {{ json_encode($positivity) }}
            var emotions = {{ json_encode($emotions) }}
            var time = {{ json_encode($time) }}
            var occurs = {{ json_encode($occurs) }}
            var replies = {{ ($analysis->replies/$analysis->total)*100 }}
            var mentions = {{ ($analysis->mentions/$analysis->total)*100 }}
            var hashtags = {{ ($analysis->hashtags/$analysis->total)*100 }}
            var retweets = {{ ($analysis->retweets/$analysis->total)*100 }}
            var links = {{ ($analysis->links/$analysis->total)*100 }}
            var media = {{ ($analysis->media/$analysis->total)*100 }}
            var retweeted = {{ ($analysis->retweet_count/$analysis->total)*100 }}
            var favorited = {{ ($analysis->favorite_count/$analysis->total)*100 }}
            
            chart("positivity", positivity);
            bar("emotions", emotions);
            activeHours("active", time, occurs);
            percentage("replies", "Replies", replies, false);
            percentage("mentions", "@Mentions", mentions, false);
            percentage("hashtags", "Hashtags", hashtags, false);
            percentage("retweets", "Retweets", retweets, false);
            percentage("links", "Includes Links", links, false);
            percentage("media", "Includes Media", media, false);
            percentage("retweeted", "Retweeted", retweeted, false);
            percentage("favorited", "Favorited", favorited, false);
        @endif
	</script>
@endsection
