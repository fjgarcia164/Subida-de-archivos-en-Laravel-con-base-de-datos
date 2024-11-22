<?php

namespace App\Http\Controllers;

use App\Models\Image; // Asegúrate de que el modelo está correctamente importado
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function index()
    {
        $images = Image::all();
        return view('images.index', compact('images'));
    }


public function create()
{
    return view('images.create');
}

public function store(Request $request)
{
    // Validar que se envíe una imagen
    $request->validate([
        'image' => 'required|image|mimes:jpg,png,jpeg,gif|max:2048',
    ]);

    // Subir el archivo a la carpeta 'storage/app/private/images'
    $file = $request->file('image');
    $filePath = $file->store('images', 'private');

    // Guardar los datos en la base de datos
    Image::create([
        'name' => $file->getClientOriginalName(),
        'path' => $filePath,
    ]);

    return redirect()->route('images.index')->with('success', 'Imagen subida exitosamente.');
}

public function show(Image $image)
{
    // Verificar si el archivo existe en la carpeta 'private'
    if (!Storage::disk('private')->exists($image->path)) {
        abort(404, 'La imagen no existe.');
    }

    // Obtener el contenido del archivo
    $file = Storage::disk('private')->get($image->path);
    $mimeType = Storage::disk('private')->mimeType($image->path);

    return response($file, 200)->header('Content-Type', $mimeType);
}

public function edit(Image $image)
{
    return view('images.edit', compact('image'));
}

public function update(Request $request, Image $image)
{
    // Validar si se envió una nueva imagen
    $request->validate([
        'image' => 'sometimes|image|mimes:jpg,png,jpeg,gif|max:2048',
    ]);

    if ($request->hasFile('image')) {
        // Eliminar la imagen anterior
        Storage::disk('private')->delete($image->path);

        // Subir la nueva imagen
        $file = $request->file('image');
        $filePath = $file->store('images', 'private');

        // Actualizar los datos en la base de datos
        $image->update([
            'name' => $file->getClientOriginalName(),
            'path' => $filePath,
        ]);
    }

    return redirect()->route('images.index')->with('success', 'Imagen actualizada exitosamente.');
}

public function destroy(Image $image)
{
    // Eliminar la imagen del almacenamiento
    Storage::disk('private')->delete($image->path);

    // Eliminar el registro de la base de datos
    $image->delete();

    return redirect()->route('images.index')->with('success', 'Imagen eliminada exitosamente.');
}
}