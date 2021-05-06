<?php

namespace App\Http\Controllers\Rest;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ContactResource;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\ContactCollection;
use App\Http\Requests\ContactSavingRequest;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new ContactCollection(Contact::orderBy('id', 'desc')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactSavingRequest $request)
    {
        $contact = Contact::create([
            'phone' => $request->input('phone'),
            'fullname' => $request->input('fullname')
        ]);

        return new ContactResource($contact);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        return new ContactResource($contact);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ContactSavingRequest $request, Contact $contact)
    {
        $contact->fill($request->validated())->save();

        return new ContactResource($contact->fresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return new SuccessResource();
    }
}
