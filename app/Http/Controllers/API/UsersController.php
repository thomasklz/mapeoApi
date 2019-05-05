<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Users;

class UsersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @SWG\Get(
     *   path="/users",
     *   tags={"Users"},
     *   summary="Listado de usuarios",
     *   operationId="getUsers",
     *   @SWG\Response(response=200, description="usuarios obtenidos correctamente"),
     * )
     *
     */
    public function index()
    {
        $users= Users::all();
        return response()->json(['redes'=>$users], 200);
    }
   /**
     * @SWG\Post(
     *   path="/users/login",
     *   tags={"Users"},
     *   summary="Comprobrar login",
     *   operationId="loginUsers",
     *   @SWG\Parameter(
     *     name="user",
     *     in="formData",
     *     description="ingresar el usuario",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="passsword",
     *     in="formData",
     *     description="ingresar la contraseña",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Response(response=201, description="login correcto"),
     *   @SWG\Response(response=404, description="usuario y/o contraseña incorrecta"),
     *   @SWG\Response(response=422, description="no se permiten valores nulos"),
     * )
     *
     */
    public function login(Request $request)
    {
        if((empty($request->user)) || (empty($request->passsword))){
                return response()->json(['message'=>'No se permiten valores nulos', 'code'=>'422'], 422);
        }else{ 
            $usuario=Users::where('user',$request->user)->first();
            if($usuario==null){
                return response()->json(['message'=>'Usuario y/o contraseña incorrecta', 'code'=>'404'], 404);  
            }
            if (Hash::check($request->passsword, $usuario->passsword))
            {
                return response()->json(['message'=>'Login correcto', 'userId'=>$usuario->id, 'user'=>$usuario->user], 200);      
            }else{
                return response()->json(['message'=>'Usuario y/o contraseña incorrecta','code'=>'404'], 404);      
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
         /**
     * @SWG\Post(
     *   path="/users",
     *   tags={"Users"},
     *   summary="Agregar usuario",
     *   operationId="createUser",
     *   @SWG\Parameter(
     *     name="nombre",
     *     in="formData",
     *     description="ingresar el nombre",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="apellido",
     *     in="formData",
     *     description="ingresar el apellido",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="f_nacimiento",
     *     in="formData",
     *     description="ingresar fecha de nacimiento",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="email",
     *     in="formData",
     *     description="ingresar el email",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="user",
     *     in="formData",
     *     description="ingresar nombre de usuario",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="imagen",
     *     in="formData",
     *     description="ingresar nombre de la imagen",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="passsword",
     *     in="formData",
     *     description="ingresar una contraseña",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Response(response=200, description="registo correcto"),
     *   @SWG\Response(response=401, description="usuario y/o correo existente"),
     *   @SWG\Response(response=422, description="no se permiten valores nulos"),
     * )
     *
     */
    public function store(Request $request)
    {
       if($request->id_facebook){
            $usuarioFacebook=Users::where('id_facebook',$request->id_facebook)
                            ->where('email',$request->email)
                            ->first();
            if($usuarioFacebook){
                    return response()->json(['message'=>'Login correcto', 'userId'=>$usuarioFacebook->id, 'user'=>$usuarioFacebook->user], 200);      
            }else{
                return response()->json(['message'=>'Usuario y/o contraseña incorrecta','code'=>'404'], 404);      
            }
        }
       
        if((empty($request->nombre)) || (empty($request->apellido))||(empty($request->f_nacimiento))
       || (empty($request->email))|| (empty($request->user))|| (empty($request->imagen))
       || (empty($request->passsword))){
                return response()->json(['message'=>'No se permiten valores nulos', 'code'=>'422'], 422);
        }else{ 
            $email=Users::where('email',$request->email)->first();
            $usuario=Users::where('user',$request->user)->first();
            if($email){
                return response()->json(['message'=>'Correo existente', 'code'=>'401'], 401);
            }
             if($usuario){
                return response()->json(['message'=>'Usuario existente', 'code'=>'401'], 401);
            }
            $user= new Users();
            $user->nombre= $request->nombre;
            $user->apellido= $request->apellido;
            $user->f_nacimiento= $request->f_nacimiento;
            $user->email= $request->email;
            $user->user= $request->user;
            $user->imagen= $request->imagen;
            $user->passsword= bcrypt($request->passsword);
            $user->id_facebook=$request->id_facebook;
            $user->save();
            $userId=$user->id;
            $userUser=$user->user;
            return response()->json(['message'=>'Usuario guardado', 'userId'=>$userId, 'user'=>$userUser], 200);      
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @SWG\Get(
     *   path="/users/{id}",
     *   tags={"Users"},
     *   summary="obtener usuario",
     *   operationId="getUser",
     *   @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="ingresar id del usuario",
     *     required=true,
     *     type="integer"
     *   ),
     *   @SWG\Response(response=200, description="usuario obtenido correctamente"),
     *   @SWG\Response(response=404, description="usuario no encontrado"),
     *   @SWG\Response(response=422, description="no se permiten valores nulos"),
     * )
     *
     */
    public function show($id)
    {
       if(empty($id)){
            return response()->json(['message'=>'No se permiten valores nulos', 'code'=>'422'], 422);
       }
        $user=Users::find($id);
        if($user==null){
            return response()->json(['message'=>'No se encontró el usuario', 'code'=>'404'], 404);
        }else{
            return response()->json(['user'=>$user], 200);
        }
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     /**
     * @SWG\Put(
     *   path="/users/{id}",
     *   tags={"Users"},
     *   summary="Actualizar usuario",
     *   operationId="updateUser",
     *   @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="ingresar id del usuario",
     *     required=true,
     *     type="integer"
     *   ),
     *   @SWG\Parameter(
     *     name="nombre",
     *     in="formData",
     *     description="ingresar el nombre",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="apellido",
     *     in="formData",
     *     description="ingresar el apellido",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="f_nacimiento",
     *     in="formData",
     *     description="ingresar fecha de nacimiento",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="email",
     *     in="formData",
     *     description="ingresar el email",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Response(response=200, description="registro correcto"),
     *   @SWG\Response(response=404, description="usuario no encontrado"),
     *   @SWG\Response(response=401, description="correo existente"),
     *   @SWG\Response(response=422, description="no se permiten valores nulos"),
     * )
     *
     */
    public function update(Request $request, $id)
    {
        if((empty($request->nombre)) || (empty($request->apellido))||(empty($request->f_nacimiento))|| (empty($request->email))){
                return response()->json(['message'=>'No se permiten valores nulos', 'code'=>'422'], 422);
        }else{
            $user= Users::where('id',$id)->first();
            if($user==null){
                return response()->json(['message'=>'No se encontró el usuario', 'code'=>'404'], 404);
            }
            $user->nombre= $request->nombre;
            $user->apellido= $request->apellido;
            $user->f_nacimiento= $request->f_nacimiento;
            if($user->email==$request->email){
                $user->email= $request->email;
                $user->save();
                return response()->json(['message'=>'Proceso realizado correctamente'], 200);
                
            }else{
                $email=Users::where('email',$request->email)->first();
                if( $email==null){
                    $user->email= $request->email;
                    $user->save();
                    return response()->json(['message'=>'Proceso realizado correctamente'], 200);
                }else{
                     return response()->json(['message'=>'Correo existente', 'code'=>'422'], 422);
                }
                
            }
        }
    }
    /**
     * @SWG\Post(
     *   path="/users/imagen/{id}",
     *   tags={"Users"},
     *   summary="Cambiar foto de perfil",
     *   operationId="changePhoto",
     *   @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="ingresar id del usuario",
     *     required=true,
     *     type="integer"
     *   ),
     *   @SWG\Parameter(
     *     name="file",
     *     in="formData",
     *     description="subir imagen",
     *     required=true,
     *     type="file"
     *   ),
     *   @SWG\Response(response=200, description="foto cambiada correctamente"),
     *   @SWG\Response(response=400, description="error al subir imagen"),
     * )
     *
     */
    public function changeimage(Request $request, $id){
        $target_dir = public_path()."/imagenes/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        $check = getimagesize($_FILES["file"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                $image=Users::where('id', $id)->first(); 
                $image->imagen = basename( $_FILES["file"]["name"]);
                $image->save();
                return response()->json(['message'=>'The file has been uploaded.'], 200);
            } else {
                return response()->json(['message'=>'Error al subir imagen'], 400);
            }
        } else {
            return response()->json(['message'=>'File is not an image.'], 400);
            $uploadOk = 0;
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
