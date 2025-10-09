<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <title>Money Link</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">
    
    <x-header title="Panel de contorl" />
    <!-- Contenedor principal -->
    <main class="flex-1 flex items-center justify-center">
        <div class="bg-white shadow-lg rounded-2xl p-8 w-full max-w-sm">
            <h2 class="text-2xl font-semibold text-gray-800 text-center mb-6">Iniciar Sesión</h2>

            @if ($errors->any())
            <div
                x-data="{ show: true }"
                x-show="show"
                x-transition
                class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                role="alert">
                <strong class="font-bold">Error:</strong>
                <span class="block sm:inline">{{ $errors->first() }}</span>
                <button
                    type="button"
                    @click="show = false"
                    class="absolute top-0 bottom-0 right-0 px-4 py-3 text-red-700">✕</button>
            </div>
            @endif

            <form action="/user/login" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                    <input type="text" id="email" name="email" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>

                <div>
                    <label for="password" class="block text-gray-700 font-medium mb-2">Contraseña</label>
                    <input type="password" id="password" name="password" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>

                <button type="submit"
                    class="w-full bg-emerald-600 text-white font-semibold py-2 rounded-lg hover:bg-emerald-700 transition">
                    Entrar
                </button>
            </form>
        </div>
    </main>
</body>