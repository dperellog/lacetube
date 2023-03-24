<?php

namespace App\Http\Controllers;

use App\Models\Activitat;
use Illuminate\Http\Request;

class ActivitatController extends Controller
{
    public function index()
    {
        $Activitatos = Activitat::all();
        return response()->json($Activitatos);
    }

    public function store(Request $request)
    {
        
        $Activitat = Activitat::create($request->all());
        return response()->json($Activitat, 201);
    }

    public function show($id)
    {
        $Activitat = Activitat::find($id);
        return response()->json($Activitat);
    }

    public function update(Request $request, $id)
    {
        $Activitat = Activitat::findOrFail($id);
        $Activitat->update($request->all());
        return response()->json($Activitat);
    }

    public function destroy($id)
    {
        $Activitat = Activitat::findOrFail($id);
        $Activitat->delete();
        return response()->json(null, 204);
    }
}