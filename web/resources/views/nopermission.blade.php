@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card-welcome">
                    <h1><b>Never Forget A Birthday Anymore!</b></h1>
                    <br>
                    <img src="{{asset('img/logo.png')}}" alt="Logo" width="100" height="100">
                    <br>
                    <p><b>Oops, it seems that you are trying to access something you don't have permission.</b></p>
                    <div class="button">
                        <a href="{{route('login')}}">
                            <button type="button" class="btn btn-warning">Go to your dashboard</button>
                        </a>
                    </div>
                    <hr>
                    <ul>
                        <li>
                            <p>Remember that we make our biggest effort to guarantee you security.</p>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
@endsection
