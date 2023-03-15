<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index()
    {
        $Videoos = Video::all();
        return response()->json($Videoos);
    }

    public function store(Request $request)
    {
        
        $Video = Video::create($request->all());
        return response()->json($Video, 201);
    }

    public function show($id)
    {
        $Video = Video::find($id);
        return response()->json($Video);
    }

    public function update(Request $request, $id)
    {
        $Video = Video::findOrFail($id);
        $Video->update($request->all());
        return response()->json($Video);
    }

    public function destroy($id)
    {
        $Video = Video::findOrFail($id);
        $Video->delete();
        return response()->json(null, 204);
    }
}