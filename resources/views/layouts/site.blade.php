<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Naja7 Host - Gestion des congés</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-white text-gray-800">

    <header class="border-b bg-white">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <img src="{{ asset('images/logo.png') }}" alt="Naja7 Host" class="h-8 w-8">
                <div class="leading-tight">
                    <p class="font-semibold text-gray-800">NAJA7 HOST</p>
                    <p class="text-xs text-gray-400">Hospitality. Simplified.</p>
                </div>
            </a>

            <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-600">
                <a href="{{ route('home') }}" class="hover:text-blue-600">Accueil</a>
                <a href="{{ route('features') }}" class="hover:text-blue-600">Fonctionnalités</a>
                <a href="{{ route('contact') }}" class="hover:text-blue-600">Contact</a>
            </nav>

            <a href="{{ route('login') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2 rounded-lg">
                Se connecter
            </a>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="border-t mt-16 py-8 text-center text-sm text-gray-400">
        &copy; {{ date('Y') }} Naja7 Host — Tous droits réservés
    </footer>

</body>
</html>
