<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Redes extends Model
{
   protected $table = 'redes';
    public $timestamps= false;
   protected $fillable = [
        'tipoRed', 'nombreRed', 'passwordRed','estadored','latitud','longitud','idUser'
    ];
   
    public  function user (){
      return $this->belongsTo(Users::class, 'idUser');
    }

}
