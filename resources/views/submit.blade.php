@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Social Hours</div>

                    <div class="card-body">
                        <form method="POST" action="/submitProcess">
                            @csrf
                            <div class="col-md-5 text-md-end">
                                <h3>Whg : {{ Auth::user()->name }}</h3>
                            </div>
                            <div class="row mb-3">
                                <h5 class="col-md-5 text-md-end">{{$error}}</h5>
                            </div>

                            <div class="row mb-3">
                                <label for="date" class="col-md-4 col-form-label text-md-end">Date</label>
                                <div class="col-md-6">
                                    <input id="date" type="date" class="form-control" name="date" autofocus required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="hours" class="col-md-4 col-form-label text-md-end">Number of Hours</label>
                                <div class="col-md-6">
                                    <input id="hours" type="time" class="form-control" name="hours" autofocus required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="description" class="col-md-4 col-form-label text-md-end">Description</label>

                                <div class="col-md-6">
                                    <input id="description" type="text" class="form-control" name="description" required>
                                </div>
                            </div>
                            <input type="hidden" name="user" value="{{ Auth::user()->username }}" />
                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Submit
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
