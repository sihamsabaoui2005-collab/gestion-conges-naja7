<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- Nom --}}
        <div>
            <x-input-label for="name" :value="__('Nom complet')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        {{-- Email --}}
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Mot de passe --}}
        <div class="mt-4">
            <x-input-label for="password" :value="__('Mot de passe')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Confirmation mot de passe --}}
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        {{-- Choix du role : c'est la partie qu'on vient d'ajouter --}}
        <div class="mt-4">
            <x-input-label :value="__('Vous êtes')" />
            <div class="grid grid-cols-2 gap-3 mt-2">

                <label class="cursor-pointer">
                    <input type="radio" name="role" value="employe" class="peer sr-only" checked>
                    <div class="border-2 border-gray-200 peer-checked:border-blue-600 peer-checked:bg-blue-50 rounded-xl p-3 transition">
                        <p class="font-semibold text-sm text-gray-800">Employé</p>
                        <p class="text-xs text-gray-500">Je demande des congés</p>
                    </div>
                </label>

                <label class="cursor-pointer">
                    <input type="radio" name="role" value="rh" class="peer sr-only">
                    <div class="border-2 border-gray-200 peer-checked:border-blue-600 peer-checked:bg-blue-50 rounded-xl p-3 transition">
                        <p class="font-semibold text-sm text-gray-800">Responsable RH</p>
                        <p class="text-xs text-gray-500">Je valide les congés</p>
                    </div>
                </label>

            </div>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                {{ __('Déjà un compte ?') }}
            </a>
            <x-primary-button class="ms-4">
                {{ __('Créer mon compte') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
