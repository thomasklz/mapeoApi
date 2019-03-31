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
    public function index()
    {
        //
    }
    public function login(Request $request)
    {
       if((empty($request->usuario)) || (empty($request->passsword))){
                return response()->json(['message'=>'No se permiten valores nulos', 'code'=>'422'], 422);
        }else{ 
            $usuario=Users::where('user',$request->user)->first();
            if($usuario==null){
                return response()->json(['message'=>'usuario y/o contraseña incorrecta', 'code'=>'404'], 404);  
            }
            if (Hash::check($request->passsword, $usuario->passsword))
            {
                return response()->json(['message'=>'login correcto', 'userId'=>$usuario->id, 'user'=>$usuario->user], 200);      
            }else{
                return response()->json(['message'=>'usuario y/o contraseña incorrecta','code'=>'404'], 404);      
            }
          
            
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       if((empty($request->nombre)) || (empty($request->apellido))||(empty($request->f_nacimiento))
       || (empty($request->email))|| (empty($request->user))|| (empty($request->imagen))
       || (empty($request->passsword))){
                return response()->json(['message'=>'No se permiten valores nulos', 'code'=>'422'], 422);
        }else{ 
            $email=Users::where('email',$request->email)->first();
            $usuario=Users::where('user',$request->user)->first();
            if($email){
                return response()->json(['message'=>'correo existente', 'code'=>'422'], 422);
            }
             if($usuario){
                return response()->json(['message'=>'usuario existente', 'code'=>'422'], 422);
            }
            $user= new Users();
            $user->nombre= $request->nombre;
            $user->apellido= $request->apellido;
            $user->f_nacimiento= $request->f_nacimiento;
            $user->email= $request->email;
            $user->user= $request->user;
            $user->imagen= $request->imagen;
            $user->passsword= bcrypt($request->passsword);
            $user->save();
            $userId=$user->id;
            $userUser=$user->user;
            return response()->json(['message'=>'usuario guardado', 'userId'=>$userId, 'user'=>$userUser], 200);      
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       if(empty($id)){
            return response()->json(['message'=>'No se permiten valores nulos', 'code'=>'404'], 404);
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
                     return response()->json(['message'=>'correo existente', 'code'=>'422'], 422);
                }
                
            }
        }
    }
    
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
