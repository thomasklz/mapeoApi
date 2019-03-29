<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Users;
use App\Http\Requests\JsonRequest;

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
        //bcrypt($request->get('password'));
    }
    
    public function changeimage(JsonRequest  $request){

        //$file = $request->file('file');
        if($request->hasfile('imagen'))
         {

            foreach($request->file('imagen') as $image)
            {
                $name=$image->getClientOriginalName();
                $image->move(public_path().'/images/', $name);  
                $data[] = $name;  
            }
         }
         
        /* $fileName = $file->getClientOriginalName();
        $path = public_path() . '/imagenes';
        $file->move($path, $fileName); 
        $image=Users::where('id', $id)->first(); 
        $image->imagen = $fileName;
        $image->save(); */
         return response()->json(['message'=>'Proceso realizado correctamente','name'=> $request->all()], 200);
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
