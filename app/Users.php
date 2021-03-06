<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'users';
    public $timestamps= false;
    protected $fillable = [
        'nombre', 'apellido', 'f_nacimiento','user', 'imagen','email','id_facebook'
    ];
    protected $hidden = [
        'passsword'
    ];
    public function redes() {
        return $this->hasMany(Redes::class, 'id');
    }
}
