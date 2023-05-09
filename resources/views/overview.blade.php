@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Social Hours Overivew :</div>

                    <div class="card-body">

                        <div class="row mb-3">
                            <h3 class="col-md-5">User : {{$user}}</h3>
                        </div>
                        <div class="row mb-3">
                            <h3 class="col-md-5">Whg : {{$whg}}</h3>
                        </div>
                        <div class="row mb-3">
                            <h3 class="col-md-5">Total hours : {{$totalTime}}</h3>
                        </div>
                        <div class="row mb-3">
                            <h3 class="col-md-5 ">List of tasks done :</h3>
                        </div>
                        @foreach($array as $value)
                        <div class="row mb-3">
                            <h5>{{$value["date"]}} <span style="color:#CD853F">|</span> {{$value["hours"]}} <span style="color:#CD853F">|</span> {{$value["description"]}}</h5>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
