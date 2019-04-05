<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Redes;
use App\Users;

use DB;
class RedesController extends Controller
{
   
   /**
     * @SWG\Swagger(
     *   basePath="/api/v01",
     *   @SWG\Info(
     *     title="Cliente rest AppMapeo",
     *     version="1.0.0",
     *     description="Client rest with Laravel",
     *     termsOfService="",
     *     @SWG\Contact(
     *             email="piposrgt@gmail.com"
     *         )
     *   )
     * )
     */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @SWG\Get(
     *   path="/redes",
     *   tags={"Redes"},
     *   summary="Listado redes compartidas",
     *   operationId="getCustomerRates",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=404, description="not found"),)
     * )
     *
     */
    public function index(Request $request)
    {
             
    //     $cd = Redes::all();
    //     $dist = '(6371 * acos(cos(radians('.$request->lng .')) 
    //                  * cos(radians('. $cd->latitud .')) 
    //                  * cos(radians('. $cd->longitud .') 
    //                  - radians('. $request->lng .')) 
    //                  + sin(radians('.$request->lat .')) 
    //                  * sin(radians('. $cd->latitud .'))))';
    //  $redes= $query 
    //     ->select() //pick the columns you want here.
    //     ->selectRaw("{$dist} AS distance")
    //     ->whereRaw("{$dist} < 25");
        
        $circle_radius = 300;
$max_distance = 200;
$lat =(double) $request->lat;
$lng = (double) $request->lng;

 $candidates = DB::select( 
               'SELECT * FROM 
                    (SELECT id, nombreRed, latitud, longitud, (' . $circle_radius . ' * acos(cos(radians(cast('.-0.8485939.' as double precision))) * cos(radians(cast(latitud as double precision))) *
                    cos(radians(cast(longitud as double precision)) - radians(cast(' . -80.1611082 . 'as double precision))) +
                    sin(radians(cast(' . -0.8485939 . ' as double precision))) * sin(radians(cast(latitud as double precision)))))
                    AS distance
                    FROM redes) AS distances
                WHERE distance < ' . $max_distance . '
                ORDER BY distance
                OFFSET 0
                LIMIT 20;
            ');
        
//    $products = DB::table('redes')
//           ->select('redes.*', DB::raw("( 6371 * acos( cos( radians( (double) -0.8485939) ) *
//                                cos( radians( latitud ) )
//                                * cos( radians( longitud ) - radians( (double)-80.1611082)
//                                ) + sin( radians((double) -0.8485939) ) *
//                                sin( radians( latitud ) ) )
//                              ) AS distance"))
//           ->having("distance", "<", $circle_radius)
//           ->get();    
        
//         $lat = $request->lat;
// $lng = $request->lng;


// $redes = Redes::where('location', 'near', [
//      '$geometry' => [
//          'type' => 'Point',
//          'coordinates' => [
//              $lng,
//              $lat,
//          ],
//      ],
//      '$maxDistance' => 100,
//  ]);


       return response()->json(['redes'=>$candidates], 200);
      //$redes= Redes::where('estadoRed','false')->orderBy('id', 'DESC')->with('user:id,user')->get();
     //  return response()->json(['redes'=>$redes], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     /**
     * @SWG\Post(
     *   path="/redes",
     *   tags={"Redes"},
     *   summary="Agregar red",
     *   operationId="createRed",
     *   @SWG\Parameter(
     *     name="tipoRed",
     *     in="formData",
     *     description="ingresar el tipo de red",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="nombreRed",
     *     in="formData",
     *     description="ingresar nombre de la red",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="passwordRed",
     *     in="formData",
     *     description="ingresar la contraseña de la red",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="estadoRed",
     *     in="formData",
     *     description="ingresar el estado (1 o 0) de la red",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="latitud",
     *     in="formData",
     *     description="ingresar la latitud",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="longitud",
     *     in="formData",
     *     description="ingresar la longitud",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="idUser",
     *     in="formData",
     *     description="ingresar el id de usuario",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Response(response=201, description="registo correcto"),
     *   @SWG\Response(response=404, description="el id de red existe"),
     *   @SWG\Response(response=422, description="no se permiten valores nulos"),
     * )
     *
     */
    public function store(Request $request)
    {
        if((empty($request->tipoRed)) || (empty($request->nombreRed))||(empty($request->passwordRed))|| ($request->estadoRed==null) || (empty($request->latitud))|| (empty($request->longitud))|| (empty($request->idUser))){
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
        $id_red=$red->id;
        return response()->json(['message'=>'Registo correcto', 'code'=>'201', 'id'=> $id_red], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @SWG\Get(
     *   path="/redes/{id}",
     *   tags={"Redes"},
     *   summary="obtener red",
     *   operationId="getRed",
     *   @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="ingresar id de la red",
     *     required=true,
     *     type="integer"
     *   ),
     *   @SWG\Response(response=200, description="datos obtenidos correctamente"),
     *   @SWG\Response(response=404, description="el id de red existe"),
     *   @SWG\Response(response=422, description="no se permiten valores nulos"),
     * )
     *
     */
    public function show($id)
    {
        if(empty($id)){
            return response()->json(['message'=>'No se permiten valores nulos', 'code'=>'422'], 422);
        }
        $red= Redes::find($id);
        if($red==null){
            return response()->json(['message'=>'No se encontró la red', 'code'=>'404'], 404);
        }else{
            return response()->json(['red'=>$red], 200);
        }
    }
    /**
     * @SWG\Get(
     *   path="/redes/user/{id}",
     *   tags={"Redes"},
     *   summary="obtener redes del usuario",
     *   operationId="getRedUser",
     *   @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="ingresar id del usuario",
     *     required=true,
     *     type="integer"
     *   ),
     *   @SWG\Response(response=200, description="datos obtenidos correctamente"),
     *   @SWG\Response(response=404, description="usuario no encontrado"),
     *   @SWG\Response(response=422, description="no se permiten valores nulos"),
     * )
     *
     */
    public function getreduser($id){
        if(empty($id)){
            return response()->json(['message'=>'No se permiten valores nulos', 'code'=>'422'], 422);
        }
        $user= Users::find($id);
         if($user==null){
            return response()->json(['message'=>'Usuario no encontrado', 'code'=>'404'], 404);
        }else{
            $redes= Redes::where('idUser', $id)->get(); 
             if($redes==null){
                return response()->json(['message'=>'El usuario no tiene redes disponibles', 'code'=>'200'], 200);
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
        $red= Redes::where('id',$id)->first();
        if($red==null){
            return response()->json(['message'=>'No se encontró la red', 'code'=>'404'], 404);
        }
        $red->estadoRed = $request->estadoRed;
        $red->save();
        return response()->json(['message'=>'Proceso realizado correctamente'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     /**
     * @SWG\Delete(
     *   path="/redes/{id}",
     *   tags={"Redes"},
     *   summary="eliminar red",
     *   operationId="deleteRedes",
     *   @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="ingresar el id de la red",
     *     required=true,
     *     type="integer"
     *   ),
     *   @SWG\Response(response=204, description="red eliminada correctamente"),
     *   @SWG\Response(response=404, description="red no encontrada"),
     * )
     *
     */
    public function destroy($id)
    {
        $red = Redes::find($id);
       if ($red){
            Redes::find($id)->delete();
            return response()->json(['message'=>'Dato eliminado', 'code'=>'200'], 200);
       }else{
            return response()->json(['message'=>'Red no encontrada'], 404);
       }
    }
}
