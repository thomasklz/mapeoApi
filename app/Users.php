<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'users';
    public $timestamps= false;
    protected $fillable = [
        'nombre', 'nombre', 'f_nacimiento','user'
    ];
    protected $hidden = [
        'email','passsword'
    ];
}
