<?php

namespace App\Http\Controllers;

use App\Models\Pilot;
use Illuminate\Http\Request;

class PilotController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'id');           // alapértelmezett: id
        $direction = $request->get('direction', 'asc'); // alapértelmezett: növekvő

        $validColumns = ['id', 'name', 'gender', 'birth_date', 'nationality', 'legacy_id'];

        if (!in_array($sort, $validColumns)) {
            $sort = 'id';
        }

        $pilots = Pilot::orderBy($sort, $direction)
            ->paginate(12)
            ->withQueryString();

        $editing = $request->query('edit') ? Pilot::find($request->query('edit')) : null;

        return view('crud', compact('pilots', 'editing', 'sort', 'direction'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'legacy_id' => ['nullable', 'integer', 'unique:pilots,legacy_id'],
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'in:F,N'],
            'birth_date' => ['required', 'date'],
            'nationality' => ['required', 'string', 'max:255'],
        ], [
            'legacy_id.unique' => 'Ez a legacy_id már létezik az adatbázisban!',
        ]);

        Pilot::create($data);

        return redirect()->route('pilots.index', $request->query())
            ->with('success', 'Pilóta sikeresen hozzáadva.');
    }

    public function update(Request $request, Pilot $pilot)
    {
        $data = $request->validate([
            'legacy_id' => ['nullable', 'integer', 'unique:pilots,legacy_id,' . $pilot->id],
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'in:F,N'],
            'birth_date' => ['required', 'date'],
            'nationality' => ['required', 'string', 'max:255'],
        ], [
            'legacy_id.unique' => 'Ez a legacy_id már létezik az adatbázisban!',
        ]);

        $pilot->update($data);

        // minden paraméter marad, csak az edit nem
        $query = $request->query();
        unset($query['edit']);

        return redirect()->route('pilots.index', $query)
            ->with('success', 'Pilóta adatai frissítve.');
    }

    public function destroy(Pilot $pilot)
    {
        $pilot->delete();
        return redirect()->route('pilots.index')->with('success', 'Pilóta törölve.');
    }
}
