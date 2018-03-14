@extends('layouts.app')

@section('content')
<div class="jumbotron text-center">
    <div class="container">
        <h1>Personality Scanner</h1>
        <p class="lead">Welcome to Personality Scanner where you can deteremine anyones personality based on their twitter account!</p>
    </div>
</div>

<div class="container">
    @component('components.analyze')
    @endcomponent
</div>
    
<div class="container">    
    <section class="no-padding" id="portfolio">
        <div class="container-fluid">
            <div class="row no-gutter popup-gallery">
                @if(isset($recents))
                    @foreach($recents as $recent)
                        <div class="col-sm-4 col-md-2">
                            <a href="{{ route('analysis.view', array('id' => $recent->id)) }}" class="portfolio-box">
                                <img src="{{ $recent->profile_image }}" class="img-responsive" alt="">
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
@endsection
