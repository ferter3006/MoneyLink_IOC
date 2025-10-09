@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">
    Perfil de Usuario
    <h3 class="font-bold text-yellow-500 text-center">Eres un
        {{$user->role->name}}
    </h3>
</h2>

<div class="space-y-4">
    <div class="flex justify-between items-center border-b border-gray-200 pb-2">
        <span class="text-gray-500 font-medium">Nombre:</span>
        <span class="text-gray-800 font-semibold">{{$user->name}}</span>
    </div>

    <div class="flex justify-between items-center border-b border-gray-200 pb-2">
        <span class="text-gray-500 font-medium">Email:</span>
        <span class="text-gray-800 font-semibold">{{$user->email}}</span>
    </div>

    <div class="pt-4 text-center">
        <a href="/logout"
            class="inline-block bg-emerald-600 text-white font-semibold px-4 py-2 rounded-lg hover:bg-emerald-700 transition">
            Cerrar sesión
        </a>
    </div>
</div>
@endsection