<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact as Contact;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $contacts = Contact::where('user_id', $user->id);
        return view('home', compact('contacts'));
    }
}
