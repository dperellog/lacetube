<?php

namespace App\Http\Controllers;
use App\Models\Video;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VideoController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function getVideo($id): JsonResponse
    {
        return response()->json(Video::findOrFail($id));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $archivo = $request->file('archivo');
        $titulo = $request->input('titulo');
        $descripcion = $request->input('descripcion');

        $video = new Video();
        $video = $video->guardarVideo($archivo, $titulo, $descripcion);

        return response()->json([
            'message' => 'El video ha sido guardado exitosamente.',
            'video' => $video,
        ], 201);
    }

    public function guardarVideo($archivo, $titulo, $descripcion)
    {
        // Guardar el archivo en el sistema de archivos local utilizando Storage de Laravel
        $nombre_archivo = $archivo->getClientOriginalName();
        $ruta_archivo = Storage::disk('local')->putFileAs('videos', $archivo, $nombre_archivo);

        // Guardar la información del video en la base de datos utilizando Eloquent
        $video = new Video([
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'nombre_archivo' => $nombre_archivo,
            'ruta_archivo' => $ruta_archivo,
        ]);
        $video->save();

        // Convertir el archivo de video utilizando FFmpeg
        $video_convertido = $ruta_archivo . '.mp4';
        shell_exec('ffmpeg -i ' . storage_path('app/' . $ruta_archivo) . ' ' . storage_path('app/' . $video_convertido));

        // Actualizar la información del video en la base de datos con la ruta del archivo convertido
        $video->ruta_archivo = $video_convertido;
        $video->save();

        return $video;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateData = $request->validate([
            'name' => 'required|unique:video|max:255',
            'description' => 'max:255',
            'mediaURL' => 'required|max:255|url',
            'activity_id' => 'exists:activity,id', // no se si es curs course o courses
            'user_id' => 'exists:user,id', // no se si es curs course o courses
        ]);

        $video = Video::find($id);

        $video->name = $request->name;
        $video->description = $request->description;
        $video->mediaURL = $request->mediaURL;
        $video->activity_id = $request->activity_id;
        $video->user_id = $request->user_id;
        $video->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}
