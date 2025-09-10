<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Election;
use Inertia\Inertia;

class ElectionController extends Controller
{
    public function index()
    {
        $election = Election::first(); // ambil pengaturan pertama
        return Inertia::render('Election/Settings', [
            'election' => $election
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        // kalau sudah ada, update; kalau belum, buat baru
        $election = Election::first();
        if ($election) {
            $election->update($request->all());
        } else {
            Election::create($request->all());
        }

        return redirect()->route('election.index')->with('success', 'Pengaturan berhasil disimpan!');
    }
}