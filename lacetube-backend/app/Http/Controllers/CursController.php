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
        $curs = Curs::findOrFail($id);
        $curs->update($request->all());
        return response()->json($curs);
    }

    public function destroy($id)
    {
        $curs = Curs::findOrFail($id);
        $curs->delete();
        return response()->json(null, 204);
    }
}