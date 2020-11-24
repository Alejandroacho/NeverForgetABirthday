@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h1>Contacts:</h1>
                    <hr>
                    @if (isset($contacts))
                        <p>There is no contacts in your list. Try to add one!</p>
                    @endif
                    @if (!isset($contacts))
                        @foreach ($contacts as $contact)
                        @endforeach
                    @endif
                </div>
                <div class="card-footer">
                    <div class="button">
                        <a href="{{route('login')}}">
                            <button type="button" class="btn btn-warning">NEW CONTACT</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
