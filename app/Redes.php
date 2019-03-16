<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Redes extends Model
{
   protected $table = 'redes';
    public $timestamps= false;
   protected $fillable = [
        'tipoRed', 'nombreRed', 'passwordRed','estadoRed','idLocations'
    ];
   
    public  function location (){
      return $this->belongsTo(Locations::class, 'idLocations');
    }
}
