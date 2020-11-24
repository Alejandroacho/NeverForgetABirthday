<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function create()
    {
        return view('contact.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->message = $request->message;
        $contact->birthday = $request->birthday;
        $contact->user_id = $user->id;
        $contact->save();
        return redirect(route('home'));
    }

    public function show(Contact $contact)
    {
        return view('contact.show', ['contact'=>$contact]);
    }

    public function edit(Contact $contact){
        return view('contact.edit',['contact'=>$contact]);
    }

    public function update(Request $request, Contact $contact)
    {
        $contact->update($request->all());
        return redirect(route('home'));
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect (route('home'));
    }

}
