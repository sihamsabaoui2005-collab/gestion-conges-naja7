@extends("layouts.site")

@section("content")
{{--
    Page Contact
    Place ce fichier dans : resources/views/pages/contact.blade.php

    Images a remplacer :
    - public/images/contact-photo.jpg -> photo de la personne (colonne de droite / fond de carte)
--}}



    <section class="max-w-5xl mx-auto px-6 py-16">
        <div class="grid md:grid-cols-2 rounded-2xl overflow-hidden shadow-lg">

            {{-- Colonne texte + formulaire --}}
            <div class="p-10 bg-gray-900 text-white">
                <h1 class="text-2xl font-bold mb-2">Nous sommes à votre écoute</h1>
                <p class="text-gray-300 text-sm mb-8">
                    Une question ? Un besoin d'aide ? N'hésitez pas à nous contacter.
                </p>

                <div class="space-y-4 text-sm mb-8">
                    <p class="flex items-center gap-2">
                        📧 <a href="mailto:contact@naja7host.com" class="hover:underline">contact@naja7host.com</a>
                    </p>
                    <p class="flex items-center gap-2">
                        📞 <a href="tel:+212600000000" class="hover:underline">+212 6 00 00 00 00</a>
                    </p>
                </div>

                <a href="mailto:contact@naja7host.com"
                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium">
                    Nous contacter
                </a>
            </div>

            {{-- Photo --}}
            <div class="hidden md:block">
                <img src="{{ asset('images/contact-photo.jpg') }}" alt="Contact Naja7 Host"
                     class="w-full h-full object-cover">
            </div>

        </div>
    </section>

@endsection
