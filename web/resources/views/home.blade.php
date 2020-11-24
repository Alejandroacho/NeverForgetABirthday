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

                    @if ($contacts->count() == 0)
                        <p>There is no contacts in your list. Try to add one!</p>
                    @endif

                    @if ($contacts->count() != 0)
                    <table class="table table-striped table-borderless">
                        <thead class="thead text-uppercase">
                            <tr>
                                <td><small><b>Name</b></small></td>
                                <td><small><b>Birthday</b></small></td>
                                <td colspan="2"><small><b>Actions</b></small></td>
                            </tr>
                        </thead>

                        @foreach ($contacts as $contact)
                        <tr>
                            <td>
                                <a href="{{Route('contact.show',$contact->id)}}" role="button"><h3>{{$contact->name}}</h3></a>
                            </td>
                            <td><h5>{{$contact->birthday}}</h5></td>
                            <td>
                                <a style="color:white" href="{{Route('contact.edit',$contact->id)}}" class="btn btn-info" role="button"><i class="fas fa-pencil-square" aria-hidden="true"></i></a>
                            </td>
                            <td>
                                <form action="{{route('contact.destroy', $contact->id)}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    @endif
                </div>
                <div class="card-footer">
                    <div class="button">
                        <a href="{{route('contact.create')}}">
                            <button type="button" class="btn btn-warning">NEW CONTACT</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
