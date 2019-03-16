<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Locations extends Model
{
    protected $table = 'locations';
    public $timestamps= false;
    protected $fillable = [
        'longitud', 'latitud'
    ];
    public function redes() {
        return $this->hasMany(Redes::class, 'id');
    }
}
