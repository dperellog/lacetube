<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Curs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CursController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cursos = Curs::all();
        return response()->json($cursos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'profesor_id' => 'required|unique:categories|max:255',
            'nom' => 'required|unique:categories|max:255',
            'descripcio' => 'required|unique:categories|max:255',
            'nom' => 'required|unique:categories|max:255',
            'nom' => 'required|unique:categories|max:255',

        ]);

        $curs = new Curs;
        $curs->curs_name = $request->curs_name;
        $curs->save();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $curs = DB::table('categories')->where('id', $id)->first();
        return response()->json($curs);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = array();
        $data['curs_name'] = $request->curs_name;
        $user = DB::table('categories')->where('id', $id)->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('categories')->where('id', $id)->delete();
    }

    public static function createSlug($str, $delimiter = '-'){

        $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
        return $slug;

    }
}
