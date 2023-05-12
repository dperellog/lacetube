<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Comment;
use App\Models\Course;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;


class RecomendedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function recomended($id)
    {
        function shuffleObjectArray($array) {
            $count = count($array);
            
            // Recorremos la array de atrás hacia adelante
            for ($i = $count - 1; $i > 0; $i--) {
              // Generamos un índice aleatorio entre 0 y $i
              $j = rand(0, $i);
              
              // Intercambiamos los elementos en las posiciones $i y $j
              $temp = $array[$i];
              $array[$i] = $array[$j];
              $array[$j] = $temp;
            }
            
            return $array;
          }
        $video = Video::findOrFail($id);
        $array1 = array($video->activity->course->students);
        shuffleObjectArray($array1[0]);
        $array2 = array_slice($array1[0]->toArray(), 0, 5);
        $ArrayVideos= array();
        foreach ($array2 as $alu) {
            $user=User::findOrFail($alu["id"]);
            $aluvideos=$user->videos;
            foreach ($aluvideos as $video){
                array_push($ArrayVideos, $video);
            }
        }
        return response()->json($ArrayVideos)
        ;
    }
}
