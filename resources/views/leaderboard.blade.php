@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Leaderboard :</div>
                    <div class="card-body">
                        @foreach($array as $key => $value)
                            <div class="row mb-3">
                                <h5><a href="{{'/overview?user='.$key}}">{{$key}} </a> <span style="color:#CD853F">|</span> {{$value[0]}}</h5>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
