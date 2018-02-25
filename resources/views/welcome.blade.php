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
    @component('components.pythonTest')
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>
                <div class="panel-body">
                    @component('components.who')
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
