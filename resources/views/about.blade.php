@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">About</div>
                <div class="panel-body">
                    This project is a personality scanner that uses a persons twitter account to analyze their personality based on what they tweet.

                    It will return back information about their personality and whether they are a positive or negative person as well as traits like happy, sad, mad, etc.

                    <h1>Setup</h1>
                    This project is created with the laravel framework.

                    Step to setup

                    Download the code and run composer install.
                    Create you database in you dev envirnment for the website
                    Create your .env file from .env.example and enter your database credentials
                    run php artisan migrate
                    run php artisan key:generate
                    The laravel project should now be correctly configured

                    <h1>Contributors</h1>
                    Natalie Jones, Connor Kurschat, Dimas Moosa, Michael Polec, Colin Schroeder, Dillon Smedley
                </div>
            </div>
        </div>
    </div>
</div>
@endsection