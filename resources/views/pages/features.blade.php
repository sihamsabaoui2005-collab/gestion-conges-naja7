@extends("layouts.site")

@section("content")
{{--
    Page Fonctionnalites
    Place ce fichier dans : resources/views/pages/features.blade.php

    Images a remplacer :
    - public/images/team-meeting.jpg -> photo de l'equipe en reunion (colonne de gauche)
--}}



    <section class="max-w-7xl mx-auto px-6 py-16">

        <h1 class="text-3xl font-bold text-center text-gray-900 mb-2">Fonctionnalités</h1>
        <p class="text-center text-gray-500 mb-12">
            Tout ce qu'il vous faut pour une gestion des congés efficace
        </p>

        <div class="grid md:grid-cols-2 gap-10 items-start">

            {{-- Photo de l'equipe --}}
            <img src="{{ asset('images/team-meeting.jpg') }}" alt="Équipe en réunion"
                 class="rounded-2xl shadow-lg w-full h-full object-cover">

            {{-- Grille des fonctionnalites --}}
            <div class="grid grid-cols-2 gap-4">

                <div class="border rounded-xl p-5">
                    <span class="text-blue-600 text-xl">📅</span>
                    <p class="font-semibold mt-2">Demandes de congé</p>
                    <p class="text-sm text-gray-500">Soumettez et suivez vos congés en quelques clics.</p>
                </div>

                <div class="border rounded-xl p-5">
                    <span class="text-green-600 text-xl">✅</span>
                    <p class="font-semibold mt-2">Validation rapide</p>
                    <p class="text-sm text-gray-500">Les RH approuvent ou refusent instantanément.</p>
                </div>

                <div class="border rounded-xl p-5">
                    <span class="text-purple-600 text-xl">🗓️</span>
                    <p class="font-semibold mt-2">Calendrier d'équipe</p>
                    <p class="text-sm text-gray-500">Visualisez les absences de toute l'équipe.</p>
                </div>

                <div class="border rounded-xl p-5">
                    <span class="text-indigo-600 text-xl">📊</span>
                    <p class="font-semibold mt-2">Suivi des soldes</p>
                    <p class="text-sm text-gray-500">Consultez vos soldes de congés à tout moment.</p>
                </div>

                <div class="border rounded-xl p-5">
                    <span class="text-orange-500 text-xl">🔔</span>
                    <p class="font-semibold mt-2">Notifications</p>
                    <p class="text-sm text-gray-500">Restez informé à chaque étape de la demande.</p>
                </div>

                <div class="border rounded-xl p-5">
                    <span class="text-teal-600 text-xl">📄</span>
                    <p class="font-semibold mt-2">Export &amp; Rapports</p>
                    <p class="text-sm text-gray-500">Générez des rapports PDF de l'historique.</p>
                </div>

            </div>
        </div>
    </section>

@endsection
