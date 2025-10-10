<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Money Link' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">
    <!-- Header -->
    <x-header :title="$headerTitle ?? 'Money Link'" :subtitle="$headerSubtitle ?? 'Gestiona tu dinero con estilo 💰'" />

    <!-- Contenido principal -->
    <main class="flex-1 flex items-center justify-center">
        <div class="w-full max-w-6xl bg-white rounded-2xl shadow-lg p-8">
            @yield('content')
        </div>
    </main>

    <!-- Footer simple -->
    <footer class="text-center text-gray-400 text-sm py-4">
        © {{ date('Y') }} Money Link. Todos los derechos reservados.
    </footer>
</body>

</html>