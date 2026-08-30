<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendContactRequest;
use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function form () {

        return view('pages.contacts');

    }

    public function send (SendContactRequest $request) {

        // Salvo i dati sul Database

        $contact = new \App\Models\Contact();

        if(auth()->user()) {
            $contact->name = auth()->user()->name;
            $contact->email = auth()->user()->email;
        } else {
            $contact->name = $request->name;
            $contact->email = $request->email;
        }
        
        $contact->message = $request->message;

        $contact->save();

        // Invio la mail

        $mail = new ContactMail($contact->name, $contact->email, $request->message);

        Mail::to('admin@example.com')->send($mail);

        return redirect()->back()->with('success', 'Messaggio inviato correttamente.');

    }
}
