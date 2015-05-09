@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Round {{ $round }}</div>

                    <div class="panel-body">
                        <div class="row">
                            @foreach($opponents as $opponent)
                                <div class="col-xs-6 col-md-">
                                    <form action="{{ route('game.running') }}" method="post">
                                        <input type="hidden" name="winnerId" value="{{
                                            $opponent['id'] }}">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        @include('parts.character', ['character' => $opponent])
                                    </form>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
