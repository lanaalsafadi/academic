<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;

class ContactController extends Controller
{
    public function showContactForm()
    {
        return view('contact');
    }

    public function storeMessage(Request $request)
    {
       
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'comments' => 'required|string|max:1000',
        ]);

       
        ContactMessage::create($request->all());

       
        return back()->with('success', 'Your message has been sent successfully!');
    }
}
