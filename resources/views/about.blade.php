@extends('layouts.app')

@section('content')
<div class="banner">
    <div class="intro-overlay">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2>About</h2>
                </div>
            </div>
        </div>
        <!-- /.container -->
    </div>
</div>
<!-- /.banner -->
<br/>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">About</div>
                <div class="panel-body">
                    <h1>Project Description</h1>
                    This project is a analytics tool that uses a person’s twitter account to analyze their personality based on what they tweet.
                    It will return information about their personality and whether they are a positive or negative person as well as traits like happy, sad, mad, etc.
                    It also returns analytical data about the twitter user and how they tweet, when they tweet and how they interact with other on twitter.
                    This tool can be extremely useful in many different scenarios, it can be used by employers to understand what type of person their potential candidate is before they make their final decision on whether to hire the person or not. It can also be used by advertisers to see if the user is a good candidate to have advertise for their product.

                    <br/>

                    **As a bonus feature, you can also analyze cashtags and hashtags and see how people feel about certain topics and companies.

                    <h1>Technologies Used</h1>
                    This project is created with the Laravel framework as a core but it uses many other technologies on top of it. Such as:
                    <br/><br/>
                    1. Sentiment and Emotion Lexicons - A list of over 14,000 lexicons with a sentiment and emotion attached to them provided by Saif M. Mohammad. Found <a href="http://saifmohammad.com/WebPages/lexicons.html">here</a>.
                    <br/>
                    2. Circliful - A jQuery plugin used to display circle percentage statistics. Found <a href="https://github.com/pguso/jquery-plugin-circliful">here</a>.
                    <br/>
                    3. Chartjs - A jQuery plugin used to display pie charts and bar charts. Found <a href="http://www.chartjs.org/">here</a>.
                    <br/>
                    4. Bootstrap - A CSS library used for the front end development to give it a more professional look and feel. Found <a href="https://getbootstrap.com/">here</a>.
                    <br/>
                    5. Font Awesome - An icon library used throughout the site to give it a more professional look and feel. Found <a href="https://fontawesome.com">here</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
