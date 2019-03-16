<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Redes;
use App\Locations;

class RedesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $redes= Redes::with('location:id,longitud,latitud')->get();
        return response()->json(['redes'=>$redes], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if((empty($request->tipoRed)) || (empty($request->nombreRed))| (empty($request->passwordRed))| (empty($request->estadoRed))| (empty($request->idLocations))){
                return response()->json(['message'=>'No se permiten valores nulos', 'code'=>'422'], 422);
        }else{
            $Location = Locations::find($request->idLocations);
            if($Location==null){
                return response()->json(['message'=>'Localización no encontrada', 'code'=>'404'], 404);
            }
        }

        $red = new Redes();
        $red->tipoRed= $request->tipoRed;
        $red->nombreRed= $request->nombreRed;
        $red->passwordRed= $request->passwordRed;
        $red->estadoRed= $request->estadoRed;
        $red->idLocations= $request->idLocations;
        $red->save();
        return response()->json(['message'=>'Registo correcto', 'code'=>'201'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $red= Redes::with('location:id,longitud,latitud')->find($id);
        if($red==null){
            return response()->json(['message'=>'No se encontró la red', 'code'=>'404'], 404);
        }else{
            return response()->json(['red'=>$red], 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
