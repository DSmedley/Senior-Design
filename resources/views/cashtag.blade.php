@extends('layouts.app')

@section('content')
<div class="banner">
    <div class="intro-overlay">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2>Cashtag Analysis</h2>
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
            @component('components.cashtag-form')
            @endcomponent
        </div>
    </div>
</div>
@else
<div class="container target">
    <div class="row">
        <div class="col-sm-12">
            <div class="sharethis-inline-share-buttons"></div>
            <h3>{{ "$".$analysis->cashtag }}</h3>
            <br>
        </div>
    </div>
    <br>
    <div class="row">
        <!--/col-3-->
        <div class="col-sm-12" style="" contenteditable="false">
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
                <div class="panel-heading">Top Contributors</div>
                <div class="panel-body">
                    <div class="container-fluid">
                        <div class="row no-gutter popup-gallery">
                            @if(isset($people))
                                @foreach($people as $person)
                                    <div class="col-sm-4 col-md-2">
                                        <a href="{{ route('analysis.name', array('name' => $person->screen_name)) }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('analysis-form-{{ $person->screen_name }}').submit();" class="portfolio-box">

                                        
                                            <img src="{{ $person->profile_image }}" class="img-responsive" alt="">
                                            <div class="portfolio-box-caption">
                                                <div class="portfolio-box-caption-content">
                                                    <div class="project-category text-faded">
                                                        {{"@".$person->screen_name}}
                                                    </div>
                                                    <div class="project-name">
                                                        {{$person->occurs}}
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <form id="analysis-form-{{ $person->screen_name }}" action="{{ route('analyze') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                            <input id="name" name="name" type="text" value="{{ $person->screen_name }}">
                                        </form>
                                    </div>
                                @endforeach
                            @else
                                Nobody is talking about ${{ $analysis->cashtag }}!
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
            
            chart("positivity", positivity);
            bar("emotions", emotions);
            activeHours("active", time, occurs);
        @endif
	</script>
@endsection
