<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
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
public static function getByDistance($lat, $lng, $distance)
{
  $results = DB::select(DB::raw('SELECT id, ( 3959 * acos( cos( radians(' . $lat . ') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(' . $lng . ') ) + sin( radians(' . $lat .') ) * sin( radians(lat) ) ) ) AS distance FROM articles HAVING distance < ' . $distance . ' ORDER BY distance') );

  return $results;
}
}
