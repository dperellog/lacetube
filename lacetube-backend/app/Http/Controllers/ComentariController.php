<?php

namespace App\Http\Controllers;

use App\Models\Comentari;
use Illuminate\Http\Request;

class ComentariController extends Controller
{
    public function index()
    {
        $Comentarios = Comentari::all();
        return response()->json($Comentarios);
    }

    public function store(Request $request)
    {
        
        $Comentari = Comentari::create($request->all());
        return response()->json($Comentari, 201);
    }

    public function show($id)
    {
        $Comentari = Comentari::find($id);
        return response()->json($Comentari);
    }

    public function update(Request $request, $id)
    {
        $Comentari = Comentari::findOrFail($id);
        $Comentari->update($request->all());
        return response()->json($Comentari);
    }

    public function destroy($id)
    {
        $Comentari = Comentari::findOrFail($id);
        $Comentari->delete();
        return response()->json(null, 204);
    }
}