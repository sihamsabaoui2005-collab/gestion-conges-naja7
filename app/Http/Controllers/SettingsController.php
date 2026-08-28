<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'fuseau_horaire' => 'required|string',
            'format_date'    => 'required|in:d/m/Y',
        ]);

        $validated['notif_email']    = $request->boolean('notif_email');
        $validated['notif_solde']    = $request->boolean('notif_solde');
        $validated['notif_demandes'] = $request->boolean('notif_demandes');

        auth()->user()->update($validated);

        return redirect()->route('settings.index')->with('success', 'Paramètres enregistrés.');
    }
}