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
            <a href="{{ route('analysis.view', array('id' => $first['analysis']->id, 'name' => $first['analysis']->screen_name)) }}" target="_blank">
                <img title="{{ $first['analysis']->name }}" class="img-circle img-responsive" src="{{ $first['analysis']->profile_image }}" alt="{{ $first['analysis']->name }}">
            </a>
        </div>
        <div class="col-md-2">
            <a href="{{ route('analysis.view', array('id' => $second['analysis']->id, 'name' => $second['analysis']->screen_name)) }}" target="_blank">
                <img title="{{ $second['analysis']->name }}" class="img-circle img-responsive" src="{{ $second['analysis']->profile_image }}" alt="{{ $second['analysis']->name }}">
            </a>
        </div>
        @if(isset($third))
            <div class="col-md-2">
                <a href="{{ route('analysis.view', array('id' => $third['analysis']->id, 'name' => $third['analysis']->screen_name)) }}" target="_blank">
                    <img title="{{ $third['analysis']->name }}" class="img-circle img-responsive" src="{{ $third['analysis']->profile_image }}" alt="{{ $third['analysis']->name }}">
                </a>
            </div>
        @endif
        @if(isset($fourth))
            <div class="col-md-2">
                <a href="{{ route('analysis.view', array('id' => $fourth['analysis']->id, 'name' => $fourth['analysis']->screen_name)) }}" target="_blank">
                    <img title="{{ $fourth['analysis']->name }}" class="img-circle img-responsive" src="{{ $fourth['analysis']->profile_image }}" alt="{{ $fourth['analysis']->name }}">
                </a>
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
                        @if($first['analysis']->location != null)
                            {{$first['analysis']->location}}
                        @else
                            Unknown
                        @endif
                    </li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Tweets</strong></span> {{ number_format($first['analysis']->tweets) }}</li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Following</strong></span> {{ number_format($first['analysis']->following) }}</li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Followers</strong></span> {{ number_format($first['analysis']->followers) }}</li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Likes</strong></span> {{ number_format($first['analysis']->likes) }}</li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Join Date</strong></span>
                        @php $d = new DateTime($first['analysis']->joined);
                            echo $d->format('D M j Y');
                        @endphp
                    </li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Time Zone</strong></span>
                        @if($first['analysis']->time_zone != null)
                            {{$first['analysis']->time_zone}}
                        @else
                            Unknown
                        @endif
                    </li>
                </ul>
            </div>
            <div class="row">
                <ul class="list-group">
                    <li class="list-group-item text-muted" contenteditable="false">{{ $second['analysis']->name }}</li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Twitter ID</strong></span> {{ $second['analysis']->twitter_id }}</li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Location</strong></span>
                        @if($second['analysis']->location != null)
                            {{$second['analysis']->location}}
                        @else
                            Unknown
                        @endif
                    </li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Tweets</strong></span> {{ number_format($second['analysis']->tweets) }}</li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Following</strong></span> {{ number_format($second['analysis']->following) }}</li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Followers</strong></span> {{ number_format($second['analysis']->followers) }}</li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Likes</strong></span> {{ number_format($second['analysis']->likes) }}</li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Join Date</strong></span>
                        @php $d = new DateTime($second['analysis']->joined);
                            echo $d->format('D M j Y');
                        @endphp
                    </li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Time Zone</strong></span>
                        @if($second['analysis']->time_zone != null)
                            {{$second['analysis']->time_zone}}
                        @else
                            Unknown
                        @endif
                    </li>
                </ul>
            </div>
            @if(isset($third))
                <div class="row">
                    <ul class="list-group">
                        <li class="list-group-item text-muted" contenteditable="false">{{ $third['analysis']->name }}</li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong class="">Twitter ID</strong></span> {{ $third['analysis']->twitter_id }}</li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong class="">Location</strong></span>
                            @if($third['analysis']->location != null)
                                {{$third['analysis']->location}}
                            @else
                                Unknown
                            @endif
                        </li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong class="">Tweets</strong></span> {{ number_format($third['analysis']->tweets) }}</li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong class="">Following</strong></span> {{ number_format($third['analysis']->following) }}</li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong class="">Followers</strong></span> {{ number_format($third['analysis']->followers) }}</li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong class="">Likes</strong></span> {{ number_format($third['analysis']->likes) }}</li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong class="">Join Date</strong></span>
                            @php $d = new DateTime($third['analysis']->joined);
                                echo $d->format('D M j Y');
                            @endphp
                        </li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong class="">Time Zone</strong></span>
                            @if($third['analysis']->time_zone != null)
                                {{$third['analysis']->time_zone}}
                            @else
                                Unknown
                            @endif
                        </li>
                    </ul>
                </div>
            @endif
            @if(isset($fourth))
                <div class="row">
                    <ul class="list-group">
                        <li class="list-group-item text-muted" contenteditable="false">{{ $fourth['analysis']->name }}</li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong class="">Twitter ID</strong></span> {{ $fourth['analysis']->twitter_id }}</li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong class="">Location</strong></span>
                            @if($fourth['analysis']->location != null)
                                {{$fourth['analysis']->location}}
                            @else
                                Unknown
                            @endif
                        </li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong class="">Tweets</strong></span> {{ number_format($fourth['analysis']->tweets) }}</li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong class="">Following</strong></span> {{ number_format($fourth['analysis']->following) }}</li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong class="">Followers</strong></span> {{ number_format($fourth['analysis']->followers) }}</li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong class="">Likes</strong></span> {{ number_format($fourth['analysis']->likes) }}</li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong class="">Join Date</strong></span>
                            @php $d = new DateTime($fourth['analysis']->joined);
                                echo $d->format('D M j Y');
                            @endphp
                        </li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong class="">Time Zone</strong></span>
                            @if($fourth['analysis']->time_zone != null)
                                {{$fourth['analysis']->time_zone}}
                            @else
                                Unknown
                            @endif
                        </li>
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
                        $replies = array(($first['analysis']->replies/$first['analysis']->total)*100, ($second['analysis']->replies/$second['analysis']->total)*100);
                        $mentions = array(($first['analysis']->mentions/$first['analysis']->total)*100, ($second['analysis']->mentions/$second['analysis']->total)*100);
                        $hashtags = array(($first['analysis']->hashtags/$first['analysis']->total)*100, ($second['analysis']->hashtags/$second['analysis']->total)*100 );
                        $retweets = array(($first['analysis']->retweets/$first['analysis']->total)*100, ($second['analysis']->retweets/$second['analysis']->total)*100);
                        $links = array(($first['analysis']->links/$first['analysis']->total)*100, ($second['analysis']->links/$second['analysis']->total)*100);
                        $media = array(($first['analysis']->media/$first['analysis']->total)*100, ($second['analysis']->media/$second['analysis']->total)*100);
                        $retweeted = array(($first['analysis']->retweet_count/$first['analysis']->total)*100, ($second['analysis']->retweet_count/$second['analysis']->total)*100);
                        $favorited = array(($first['analysis']->favorite_count/($first['analysis']->total-$first['analysis']->retweets))*100, ($second['analysis']->favorite_count/($second['analysis']->total-$second['analysis']->retweets))*100);
                        if(isset($third)){
                            array_push($positivity, $third['analysis']->neutral, $third['analysis']->positive, $third['analysis']->negative);
                            array_push($compareNames, $third['analysis']->name);
                            array_push($compare1, $third['analysis']->anger, $third['analysis']->anticipation);
                            array_push($compare2, $third['analysis']->disgust, $third['analysis']->fear);
                            array_push($compare3, $third['analysis']->joy, $third['analysis']->sadness);
                            array_push($compare4, $third['analysis']->surprise, $third['analysis']->trust);
                            array_push($replies, ($third['analysis']->replies/$third['analysis']->total)*100);
                            array_push($mentions, ($third['analysis']->mentions/$third['analysis']->total)*100);
                            array_push($hashtags, ($third['analysis']->hashtags/$third['analysis']->total)*100 );
                            array_push($retweets, ($third['analysis']->retweets/$third['analysis']->total)*100);
                            array_push($links, ($third['analysis']->links/$third['analysis']->total)*100);
                            array_push($media, ($third['analysis']->media/$third['analysis']->total)*100);
                            array_push($retweeted, ($third['analysis']->retweet_count/$third['analysis']->total)*100);
                            array_push($favorited, ($third['analysis']->favorite_count/($third['analysis']->total-$third['analysis']->retweets))*100);
                        }
                        if(isset($fourth)){
                            array_push($positivity, $fourth['analysis']->neutral, $fourth['analysis']->positive, $fourth['analysis']->negative);
                            array_push($compareNames, $fourth['analysis']->name);
                            array_push($compare1, $fourth['analysis']->anger, $fourth['analysis']->anticipation);
                            array_push($compare2, $fourth['analysis']->disgust, $fourth['analysis']->fear);
                            array_push($compare3, $fourth['analysis']->joy, $fourth['analysis']->sadness);
                            array_push($compare4, $fourth['analysis']->surprise, $fourth['analysis']->trust);
                            array_push($replies, ($fourth['analysis']->replies/$fourth['analysis']->total)*100);
                            array_push($mentions, ($fourth['analysis']->mentions/$fourth['analysis']->total)*100);
                            array_push($hashtags, ($fourth['analysis']->hashtags/$fourth['analysis']->total)*100 );
                            array_push($retweets, ($fourth['analysis']->retweets/$fourth['analysis']->total)*100);
                            array_push($links, ($fourth['analysis']->links/$fourth['analysis']->total)*100);
                            array_push($media, ($fourth['analysis']->media/$fourth['analysis']->total)*100);
                            array_push($retweeted, ($fourth['analysis']->retweet_count/$fourth['analysis']->total)*100);
                            array_push($favorited, ($fourth['analysis']->favorite_count/($fourth['analysis']->total-$fourth['analysis']->retweets))*100);
                        }
                    @endphp
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Inside Their Tweets</div>
                <div class="panel-body" id="analyticsCompare">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="percentage" id="replies" data-toggle="tooltip" title="Percent of tweets that were replies."></div>
                        </div>
                        <div class="col-sm-6">
                            <div class="percentage" id="mentions" data-toggle="tooltip" title="Percent of tweets that had @mentions."></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="percentage" id="hashtags" data-toggle="tooltip" title="Percent of tweets that have hashtags."></div>
                        </div>
                        <div class="col-sm-6">
                            <div class="percentage" id="retweets" data-toggle="tooltip" title="Percent of tweets that were retweets."></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="percentage" id="links" data-toggle="tooltip" title="Percent of tweets that contain links."></div>
                        </div>
                        <div class="col-sm-6">
                            <div class="percentage" id="media" data-toggle="tooltip" title="Percent of tweets that contains media."></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="percentage" id="retweeted" data-toggle="tooltip" title="Percent of tweets retweeted by others."></div>
                        </div>
                        <div class="col-sm-6">
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
                        $time3 = array();
                        $occurs3 = array();
                        $time4 = array();
                        $occurs4 = array();
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
                    @if(isset($third['hours']))
                        @foreach($third['hours'] as $hour)
                            @php
                                array_push($time3, $hour->hour);
                                array_push($occurs3, $hour->occurs);
                            @endphp
                        @endforeach
                        @php
                            array_push($time, $time3);
                            array_push($occurs, $occurs3);
                        @endphp
                    @endif
                    @if(isset($fourth['hours']))
                        @foreach($fourth['hours'] as $hour)
                            @php
                                array_push($time4, $hour->hour);
                                array_push($occurs4, $hour->occurs);
                            @endphp
                        @endforeach
                        @php
                            array_push($time, $time4);
                            array_push($occurs, $occurs4);
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
            var replies = {{ json_encode($replies) }}
            var mentions = {{ json_encode($mentions) }}
            var hashtags = {{ json_encode($hashtags) }}
            var retweets = {{ json_encode($retweets) }}
            var links = {{ json_encode($links) }}
            var media = {{ json_encode($media) }}
            var retweeted = {{ json_encode($retweeted) }}
            var favorited = {{ json_encode($favorited) }}
            var time = {{ json_encode($time) }}
            var occurs = {{ json_encode($occurs) }}

            positive("positivity", comNames, positivity);
            compare("compare1", comNames, ['Anger', 'Anticiaption'], com1);
            compare("compare2", comNames, ['Disgust', 'Fear'], com2);
            compare("compare3", comNames, ['Joy', 'Sadness'], com3);
            compare("compare4", comNames, ['Surprise', 'Trust'], com4);
            percentage("replies", comNames, "Replies", replies, false);
            percentage("mentions", comNames, "@Mentions", mentions, false);
            percentage("hashtags", comNames, "Hashtags", hashtags, false);
            percentage("retweets", comNames, "Retweets", retweets, false);
            percentage("links", comNames, "Includes Links", links, false);
            percentage("media", comNames, "Includes Media", media, false);
            percentage("retweeted", comNames, "Retweeted", retweeted, false);
            percentage("favorited", comNames, "Favorited", favorited, false);
            activeHours("active", comNames, time, occurs);
        @endif
	</script>
@endsection
