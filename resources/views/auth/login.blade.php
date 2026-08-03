{{--
    Page de connexion - style Naja7 Host
    Place ce fichier dans : resources/views/auth/login.blade.php

    A remplacer par tes propres images :
    - public/images/login-bg.jpg   -> photo de fond (bureau / ordinateur)
    - public/images/logo-icon.png  -> petit logo dans le cercle bleu (optionnel,
      sinon on garde l'icone SVG deja en place)
--}}

<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-cover bg-center"
         style="background-image: url('{{ asset('images/login-bg.jpg') }}');">

        {{-- voile sombre au-dessus de la photo pour que le texte reste lisible --}}
        <div class="absolute inset-0 bg-black/40"></div>

        {{-- carte de connexion --}}
        <div class="relative z-10 w-full max-w-md bg-white/95 rounded-2xl shadow-xl p-8">

            {{-- icone ronde bleue en haut --}}
            <div class="flex justify-center mb-4">
                <div class="w-14 h-14 rounded-full bg-blue-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 11c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M6 21v-1a6 6 0 0112 0v1" />
                    </svg>
                </div>
            </div>

            <h1 class="text-xl font-semibold text-center text-gray-800">
                Connexion à votre compte
            </h1>
            <p class="text-sm text-center text-gray-500 mt-1 mb-6">
                Accédez à votre espace personnel
            </p>

            {{-- message de session (ex: lien de reinitialisation envoye) --}}
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                {{-- Email --}}
                <div>
                    <x-input-label for="email" value="Email" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                   :value="old('email')" required autofocus autocomplete="username"
                                   placeholder="votre@adresse.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                {{-- Mot de passe --}}
                <div>
                    <x-input-label for="password" value="Mot de passe" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                                   required autocomplete="current-password" placeholder="••••••••" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                {{-- Se souvenir de moi + mot de passe oublie --}}
                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600">
                        <span class="ml-2 text-sm text-gray-600">Se souvenir de moi</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-blue-600 hover:underline" href="{{ route('password.request') }}">
                            Mot de passe oublié ?
                        </a>
                    @endif
                </div>

                {{-- Bouton de connexion --}}
                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 rounded-lg transition">
                    Se connecter
                </button>
            </form>

            {{-- lien vers l'inscription RH --}}
            @if (Route::has('register'))
                <p class="text-center text-sm text-gray-500 mt-6">
                    Nouveau ici ?
                    <a href="{{ route('register') }}" class="text-blue-600 font-medium hover:underline">
                        Inscription RH
                    </a>
                </p>
            @endif
        </div>
    </div>
</x-guest-layout>
