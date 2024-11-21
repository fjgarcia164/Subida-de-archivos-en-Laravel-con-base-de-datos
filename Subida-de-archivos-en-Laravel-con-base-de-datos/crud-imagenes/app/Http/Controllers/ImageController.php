<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

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
        $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        $file = $request->file('image');
        $filePath = $file->store('images', 'private');

        $image = Image::create([
            'name' => $file->getClientOriginalName(),
            'path' => $filePath,
        ]);

        return redirect()->route('images.index')->with('success', 'Imagen subida exitosamente.');
    }

    public function show(Image $image)
    {
        if (!Storage::disk('private')->exists($image->path)) {
            abort(404, 'La imagen no existe.');
        }

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
        $request->validate([
            'image' => 'sometimes|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('private')->delete($image->path);

            $file = $request->file('image');
            $filePath = $file->store('images', 'private');

            $image->update([
                'name' => $file->getClientOriginalName(),
                'path' => $filePath,
            ]);
        }

        return redirect()->route('images.index')->with('success', 'Imagen actualizada exitosamente.');
    }

    public function destroy(Image $image)
    {
        Storage::disk('private')->delete($image->path);
        $image->delete();

        return redirect()->route('images.index')->with('success', 'Imagen eliminada exitosamente.');
    }
}
