<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCassetteRequest;
use App\Models\Cassette;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class CassetteController extends Controller
{
    // Rak kaset milik user yang login (ASC)
    public function index(Request $request)
    {
        $cassettes = $request->user()
            ->cassettes()
            ->withCount('tracks')
            ->latest()
            ->get();

        return Inertia::render('Shelf', ['cassettes' => $cassettes]);
    }

    public function create()
    {
        return Inertia::render('CassetteForm');
    }

    public function store(StoreCassetteRequest $request)
    {
        $request->user()->cassettes()->create($request->validated());

        return redirect()->route('shelf.index');
    }

    public function update(StoreCassetteRequest $request, Cassette $cassette)
    {
        Gate::authorize('update', $cassette); 

        $cassette->update($request->validated());

        return redirect()->route('shelf.index');
    }

    public function destroy(Cassette $cassette)
    {
        Gate::authorize('delete', $cassette);

        $cassette->delete();

        return redirect()->route('shelf.index');
    }
}