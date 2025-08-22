<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use DB;


class MapController extends Controller
{


    public function getMap(Request $request){

        $startx = $request->startWidth;
        $endx = $request->endWidth;
        $starty = $request->startHeight;
        $endy = $request->endHeight;

        $mapa = DB::table('mapas')->where('x', '>=', $starty)->where('x', '<', $endy)->where('y', '>=', $startx)->where('y', '<', $endx)->get();
        
        return response()->json($mapa);

    }



}
?>