<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use Illuminate\Support\Facades\Gate;

class ContactController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return 'Hello World';
       $contact = Contact::latest()->where('user_id',\Auth::user()->id)->get();
        return response()->json([
            'message' => 'success',
                'data' => $contact ]
        ,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreContactRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContactRequest $request)
    {
        $contact = new Contact();
        $contact->name = $request->name;
        $contact->phone = $request->phone;
        $contact->user_id = \Auth::id();
        $contact->save();
        return response()->json($data=[$contact], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        $contact = Contact::find($contact->id);

        if(Gate::denies('view',$contact)){
            return response()->json([
                'message' => 'This is not your data'
            ],403);
        }

        return response()->json([
            'message' => 'success',
            $contact],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateContactRequest  $request
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContactRequest $request, Contact $contact)
    {
        if($request->has('name') ){
            $contact->name = $request->name;
        }

        if($request->has('phone')){
            $contact->phone = $request->phone;
        }

        $contact->update();

        return response()->json($data=[$contact]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return response()->json($data=[$contact]);
    }
}
