<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class RuteController extends Controller
{
    public function index()
    {
        // ambil data contact pertama
        $contact = Contact::first();

        // kirim ke view
        return view('cek-rute', compact('contact'));
    }
}
