@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                <div class="jumbotron">
                    <h1>My favourite THE character</h1>

                    <p class="lead">
                        Have you noticed that there are a lot of "The" characters in the Marvel world? Have you
                        thought about which one could be your favourite one? This is probably the right time and
                        you're at the right place!<br /><br />

                        This is a rapid-development project which uses the <a href="http://developer.marvel
                        .com/">Marvel developer API</a>.
                    </p>

                    <p><a class="btn btn-lg btn-success" href="{{ route('game.start') }}" role="button">Start
                            game</a></p>
                </div>
            </div>
        </div>
    </div>
@endsection
