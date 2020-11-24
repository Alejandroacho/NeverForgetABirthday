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
                    <p><b>With this tool you only have to add a contact, write a letter for his birthday, and finally add his birthday date.</b></p>
                    <p><b>We will send him the letter you wrote at his birthday! 🎉</b></p>
                    <div class="button">
                        <a href="{{route('login')}}">
                            <button type="button" class="btn btn-warning">START NOW</button>
                        </a>
                    </div>
                    <hr>
                    <ul>
                        <li>
                            <p>You can personalize the message for your contact.</p>
                        </li>
                        <li>
                            <p>Receive a reminder one week before your contact's birthday.</p>
                        </li>
                        <li>
                            <p>We make our biggest effort to guarantee you security.</p>
                        </li>
                        <li>
                            <p>Both your info and the info of your contacts will not be used for comercial purposes.</p>
                        </li>
                    </ul>


                </div>
            </div>
        </div>
    </div>
@endsection
