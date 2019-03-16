<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Redes extends Model
{
   protected $table = 'redes';
    public $timestamps= false;
   protected $fillable = [
        'tipoRed', 'nombreRed', 'passwordRed','estadoRed','latitud','longitud','idUser'
    ];
   
    public  function user (){
      return $this->belongsTo(Users::class, 'idUser');
    }
}
