<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCassetteRequest;
use App\Models\Cassette;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class CassetteController extends Controller
{
    // Rak kaset milik user yang login, terbaru di depan
    public function index(Request $request)
    {
        $cassettes = $request->user()
            ->cassettes()
            ->withCount('tracks')
            ->latest()
            ->latest('id') // pembanding kalau dua kaset dibuat di detik yang sama
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

    // Halaman edit: form yang sama dengan buat kaset, tapi sudah terisi
    public function edit(Cassette $cassette)
    {
        Gate::authorize('update', $cassette); // bukan pemilik = 403

        return Inertia::render('CassetteForm', ['cassette' => $cassette]);
    }

    public function update(StoreCassetteRequest $request, Cassette $cassette)
    {
        Gate::authorize('update', $cassette); // bukan pemilik = 403

        $cassette->update($request->validated());

        return redirect()->route('shelf.index');
    }

    public function destroy(Cassette $cassette)
    {
        Gate::authorize('delete', $cassette); // bukan pemilik = 403

        $cassette->delete();

        return redirect()->route('shelf.index');
    }
}
