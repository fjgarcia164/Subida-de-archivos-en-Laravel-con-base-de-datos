<!DOCTYPE html>
<html>
<head>
    <title>CRUD de Imágenes</title>
</head>
<body>
    <h1>CRUD de Imágenes</h1>
    <a href="{{ route('images.create') }}">Subir nueva imagen</a>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <ul>
        @foreach ($images as $image)
            <li>
                <a href="{{ route('images.show', $image->id) }}" target="_blank">{{ $image->name }}</a>
                <a href="{{ route('images.edit', $image->id) }}">Editar</a>
                <form action="{{ route('images.destroy', $image->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Eliminar</button>
                </form>
            </li>
        @endforeach
    </ul>
</body>
</html>
