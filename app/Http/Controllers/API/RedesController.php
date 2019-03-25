<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Redes;
use App\Users;

class RedesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $redes= Redes::with('user:id,user')->get();
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
        if((empty($request->tipoRed)) || (empty($request->nombreRed))||(empty($request->passwordRed))|| (empty($request->estadoRed))|| (empty($request->latitud))|| (empty($request->longitud))|| (empty($request->idUser))){
                return response()->json(['message'=>'No se permiten valores nulos', 'code'=>'422'], 422);
        }else{
            $user = Users::find($request->idUser);
            if($user==null){
                return response()->json(['message'=>'Usuario no encontrado', 'code'=>'404'], 404);
            }
        }

        $red = new Redes();
        $red->tipoRed= $request->tipoRed;
        $red->nombreRed= $request->nombreRed;
        $red->passwordRed= $request->passwordRed;
        $red->estadoRed= $request->estadoRed;
        $red->latitud= $request->latitud;
        $red->longitud= $request->longitud;
        $red->idUser= $request->idUser;
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
        $red= Redes::find($id);
        if($red==null){
            return response()->json(['message'=>'No se encontró la red', 'code'=>'404'], 404);
        }else{
            return response()->json(['red'=>$red], 200);
        }
    }
    public function getreduser($id){
        $user= Users::find($id);
         if($user==null){
            return response()->json(['message'=>'Usuario no encontrado', 'code'=>'404'], 404);
        }else{
            $redes= Redes::where('idUser', $id)->get(); 
             if($redes==null){
                return response()->json(['message'=>'No hay redes disponibles', 'code'=>'200'], 200);
             }else{
                return response()->json(['redes'=>$redes], 200);
             }
            
        }
    }
    /*
    **
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $red= Redes::where('id',$id)->get();
        if($red==null){
            return response()->json(['message'=>'No se encontró la red', 'code'=>'404'], 404);
        }else{
            if($red->estadoRed==1){
                $red->estadoRed=0;
                $red->save();
            }else{
                $red->estadoRed= 1;
                $red->save();
            }
            return response()->json(['message'=>'Proceso realizado correctamente'], 200);
        }
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
