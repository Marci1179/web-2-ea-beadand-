<?php

namespace App\Http\Controllers;

use App\Models\Result;

class AdatbController extends Controller
{
    public function index()
    {
        $rows = Result::with(['pilot','grandPrix'])
            ->orderByDesc('grand_prix_id')
            ->take(100)
            ->get();

        return view('adatb', compact('rows'));
    }
}
