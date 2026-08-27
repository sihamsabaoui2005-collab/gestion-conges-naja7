<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        // Collègues du même département (pour la modale "Voir les membres du département")
        $collegues = collect();
        if ($user->departement) {
            $collegues = User::where('departement', $user->departement)
                ->where('id', '!=', $user->id)
                ->orderBy('name')
                ->get();
        }

        return view('profile.edit', [
            'user'      => $user,
            'collegues' => $collegues,
        ]);
    }

    /**
     * Update the user's profile information (nom, email, photo + champs étendus).
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // Photo de profil (champ optionnel, ajouté séparément du reste du formulaire)
        if ($request->hasFile('photo')) {
            $request->validate([
                'photo' => ['image', 'max:2048'], // 2 Mo max
            ]);

            // Supprime l'ancienne photo si elle existe
            if ($request->user()->photo_path) {
                Storage::disk('public')->delete($request->user()->photo_path);
            }

            $chemin = $request->file('photo')->store('avatars', 'public');
            $request->user()->photo_path = $chemin;
        }

        // Champs étendus du profil (téléphone, poste, département, infos personnelles...)
        // Validés ici séparément car ils ne font pas partie de ProfileUpdateRequest.
        $champsEtendus = $request->validate([
            'telephone' => ['nullable', 'string', 'max:20'],
            'poste' => ['nullable', 'string', 'max:100'],
            'departement' => ['nullable', 'string', 'max:100'],
            'cin' => ['nullable', 'string', 'max:20'],
            'date_naissance' => ['nullable', 'date'],
            'lieu_naissance' => ['nullable', 'string', 'max:100'],
            'nationalite' => ['nullable', 'string', 'max:100'],
            'adresse' => ['nullable', 'string', 'max:255'],
            'situation_familiale' => ['nullable', 'string', 'max:50'],
        ]);

        $request->user()->fill($champsEtendus);

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}