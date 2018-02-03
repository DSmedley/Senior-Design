@extends('layouts.app')

@section('content')
<div class="jumbotron text-center">
    <div class="container">
        <h1>Personality Scanner</h1>
        <p class="lead">Welcome to Personality Scanner where you can deteremine anyones personality based on their twitter account!</p>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @component('components.who')
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
    @component('components.analyze')
    @endcomponent
</div>
@endsection
