@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1>Create a contact</h1>
                </div>
                <div class="card-body">
                    <form action="{{Route('contact.store')}}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control"/>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" class="form-control"/>
                        </div>

                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea class="form-control rounded-0" id="message" name="message" rows="7" cols="50"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="birthday">Birthday</label>
                            <input type="date" id="birthday" name="birthday" class="form-control">
                        </div>

                        <input type="submit" value="Add Contact" class="btn btn-primary">
                    </form>

                </div>
                <div class="card-footer">
                    <a href="{{Route('home')}}" class="btn btn-secondary">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
