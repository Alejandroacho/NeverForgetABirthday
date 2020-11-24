@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-header">
                    <h1>Contact details</h1>
                </div>

                <div class="card-body">
                    <table>
                        <tr>
                            <td>
                                <h4>Name:</h4>
                            </td>
                            <td>
                                <h4>{{$contact->name}}</h4>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h4>Email:</h4>
                            </td>
                            <td>
                                <h4>{{$contact->email}}</h4>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h4>Birthday:</h4>
                            </td>
                            <td>
                                <h4>{{$contact->birthday}}</h4>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h4>Message:</h4>
                            </td>
                            <td>
                                <h4>{{$contact->message}}</h4>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="card-footer">
                    <a href="{{Route('contact.edit',$contact->id)}}" class="btn btn-primary">Edit</a>
                    <a href="{{Route('home')}}" class="btn btn-secondary">Back</a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
