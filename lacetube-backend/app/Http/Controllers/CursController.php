<?php

namespace App\Http\Controllers;

use App\Models\Curs;
use Illuminate\Http\Request;

class CursController extends Controller
{
    public function index()
    {
        $cursos = Curs::all();
        return response()->json($cursos);
    }

    public function store(Request $request)
    {
        
        $curs = Curs::create($request->all());
        return response()->json($curs, 201);
    }

    public function show($id)
    {
        $curs = Curs::find($id);
        return response()->json($curs);
    }

    public function update(Request $request, $id)
    {

        $validateData = $request->validate([
            'profesor_id' => 'exists:users,id',
            'nom' => 'required|unique:curs|max:255',
            'descripcio' => 'required|max:255',
            'any' => 'required|max:255',
            'cursPare' => 'exists:curs,id',
        ]);

        $curs = Curs::find($id);

        $curs->profesor_id = $request->profesor_id;
        $curs->nom = $request->nom;
        $curs->descripcio = $request->descripcio;
        $curs->any = $request->any;
        $curs->cursPare = $request->cursPare;
        $curs->save();

    }

    public function destroy($id)
    {
        $curs = Curs::findOrFail($id);
        $curs->delete();
        return response()->json(null, 204);
    }
}