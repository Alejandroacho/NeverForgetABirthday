<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Contact;
use Validator;
use App\Http\Resources\Contact as ContactResource;
use Illuminate\Support\Facades\Auth;

class ApiContactController extends BaseController
{
    public function index()
    {
        $user = Auth::user();
        $contacts = Contact::where('user_id', $user->id)->get();
        return $this->sendResponse(ContactResource::collection($contacts), 'Contacts retrieved successfully.');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $user = Auth::user();
        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required',
            'birthday' => 'required',
            'message' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input['user_id'] = $user->id;
        $Contact = Contact::create($input);
        return $this->sendResponse(new ContactResource($Contact), 'Contact created successfully.');
    }

    public function show($id)
    {
        $user = Auth::user();
        $Contact = Contact::find($id);

        if (is_null($Contact)) {
            return $this->sendError('Contact not found.');
        }
        if ($user->id == $Contact->user_id){
            return $this->sendResponse(new ContactResource($Contact), 'Contact retrieved successfully.');
        }
        return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
    }

    public function update(Request $request, Contact $Contact)
    {
        $input = $request->all();
        $user = Auth::user();
        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required',
            'birthday' => 'required',
            'message' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        if ($user->id == $Contact->user_id){
            $Contact->name = $input['name'];
            $Contact->email = $input['email'];
            $Contact->birthday = $input['birthday'];
            $Contact->message = $input['message'];
            $Contact->save();
            return $this->sendResponse(new ContactResource($Contact), 'Contact updated successfully.');
        }
        return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
    }

    public function destroy(Contact $Contact)
    {
        $user = Auth::user();
        if ($user->id == $Contact->user_id){
            $Contact->delete();
            return $this->sendResponse([], 'Contact deleted successfully.');
        }
        return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
    }
}
