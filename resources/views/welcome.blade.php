@extends('layouts.app')

@section('content')
<div class="intro-header">
    <div class="intro-overlay">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="intro-message">
                        <h1>{{ config('app.name', 'Laravel') }}</h1>
                        <h3>Twitter Analytics</h3>
                        <hr class="intro-divider">
                        <form class="form-horizontal" method="POST" action="{{ route('analyze') }}">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-sm-5 col-sm-offset-3">
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
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <button type="submit" id="analyzeButton" data-loading-text="Loading..." name="analyze" class="btn btn-default">
                                            Analyze
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <section id="services">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">What we do</h2>
                    <hr class="primary">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <span class="fas fa-info fa-4x text-primary sr-icons"></span>
                        <h3>User Details</h3>
                        <p class="text-muted">The user details section includes general information about the user being analyzed like tweets, location and join date.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <span class="fas fa-chart-bar fa-4x text-primary sr-icons"></span>
                        <h3>Sentiment</h3>
                        <p class="text-muted">The sentiment section displays the users overall positivity as well as a more in-depth analysis of eight emotions and how many times the user displays those emotions.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <span class="fas fa-level-down-alt fa-4x text-primary sr-icons"></span>
                        <h3>Inside Their Tweets</h3>
                        <p class="text-muted">This section displays statistics about how the user tweets and interacts with their followers and the people that they follow such as retweets, mentions and hashtags.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <span class="fas fa-comments fa-4x text-primary sr-icons"></span>
                        <h3>Active Hours</h3>
                        <p class="text-muted">In the active hours section we compile all of the users tweets that we pull into hours of the day to help determine the times that they are the most active on twitter.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="no-padding" id="portfolio">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Recently Analyzed</h2>
                    <hr class="primary">
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row no-gutter popup-gallery">
                @if(isset($recents))
                    @foreach($recents as $recent)
                        <div class="col-sm-4 col-md-2">
                            <a href="{{ route('analysis.view', array('id' => $recent->id, 'name' => $recent->screen_name)) }}" class="portfolio-box">
                                <img src="https://avatars.io/twitter/{{ $recent->screen_name }}" class="img-responsive" alt="{{'@'.$recent->screen_name}}">
                                <div class="portfolio-box-caption">
                                    <div class="portfolio-box-caption-content">
                                        <div class="project-category text-faded">
                                            {{"@".$recent->screen_name}}
                                        </div>
                                        <div class="project-name">
                                            {{$recent->name}}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @else
                    There are no recent analyses!
                @endif
            </div>
        </div>
    </section>
</div>

<div class="banner">
    <div class="intro-overlay">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2>{{ config('app.name', 'Laravel') }}</h2>
                </div>
            </div>
        </div>
        <!-- /.container -->
    </div>
</div>
<!-- /.banner -->
@endsection
