<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado en vivo</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="flex flex-col items-center justify-center h-screen bg-gray-100">
    <h1 class="text-3xl font-bold mb-4 text-gray-700">Estado del servidor</h1>

    <div id="status" class="text-xl text-blue-600">Esperando actualización...</div>

    <button id="update" class="mt-8 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">
        Emitir actualización
    </button>
</body>
</html>
