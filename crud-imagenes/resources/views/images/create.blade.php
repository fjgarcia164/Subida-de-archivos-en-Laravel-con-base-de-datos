<!DOCTYPE html>
<html>
<head>
    <title>Subir Imagen</title>
</head>
<body>
    <h1>Subir Nueva Imagen</h1>
    <form action="{{ route('images.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="image">Selecciona una imagen:</label>
        <input type="file" name="image" id="image" required>
        <button type="submit">Subir</button>
    </form>
</body>
</html>
