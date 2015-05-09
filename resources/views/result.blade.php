@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Your favourite THE Marvel character is {{ $winner['name'] }}</div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-6 col-md-">
                                @include('parts.character', ['character' => $winner])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
