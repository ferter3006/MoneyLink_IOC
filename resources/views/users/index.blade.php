<div>
    <h1>Hola Mundo</h1>
    @foreach ($users as $user)
        <p>{{ $user->name }}</p>
    @endforeach
</div>
