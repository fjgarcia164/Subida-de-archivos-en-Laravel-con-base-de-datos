<!DOCTYPE html>
<html>
<head>
    <title>Editar Imagen</title>
</head>
<body>
    <h1>Editar Imagen</h1>
    <form action="{{ route('images.update', $image->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <label for="image">Selecciona una nueva imagen (opcional):</label>
        <input type="file" name="image" id="image">
        <button type="submit">Actualizar</button>
    </form>
</body>
</html>
