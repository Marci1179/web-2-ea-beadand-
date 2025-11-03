<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Message;

class ContactController extends Controller
{
    // Kapcsolat űrlap megjelenítése
    public function create()
    {
        return view('kapcsolat');
    }

    // Beküldés kezelése, validáció + mentés
    public function store(ContactRequest $request)
    {
        Message::create($request->validated());

        return redirect()
            ->route('kapcsolat.create')
            ->with('success', 'Köszönjük! Üzenetedet rögzítettük.');
    }

    // Üzenetek listája fordított időrendben
    public function index()
    {
        $messages = Message::orderBy('created_at', 'desc')->paginate(10);
        return view('uzenet', compact('messages'));
    }
}
