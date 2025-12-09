<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class ContactFormController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'subject' => 'required|max:255',
            'message' => 'required'
        ]);

        // Kirim email ke admin
        Mail::to('porlempikapadang@gmail.com')->send(new ContactFormMail($validated));

        return redirect()->to(url()->previous() . '#contact')->with('success', 'Pesan kamu berhasil dikirim!');

    }
}
