<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    
    public function changeimage(Request $request, $id){

        //$file = $request->file('file');
        $target_dir = public_path()."imagenes/";
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
                return response()->json(['message'=>'The file '. basename( $_FILES["file"]["name"]). ' has been uploaded.'], 200);
            } else {
                return response()->json(['message'=>'Error al subir imagen'], 400);
            }
        } else {
            return response()->json(['message'=>'File is not an image.'], 400);
            $uploadOk = 0;
        }
        
        // if($request->hasfile('imagen'))
        //  {

        //     foreach($request->file('imagen') as $image)
        //     {
        //         $name=$image->getClientOriginalName();
        //         $image->move(public_path().'/images/', $name);  
        //         $data[] = $name;  
        //     }
        //  }
         
        /* $fileName = $file->getClientOriginalName();
        $path = public_path() . '/imagenes';
        $file->move($path, $fileName); 
        $image=Users::where('id', $id)->first(); 
        $image->imagen = $fileName;
        $image->save(); */
        // return response()->json(['message'=>$target_file,'name'=> $request->all()], 200);
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
