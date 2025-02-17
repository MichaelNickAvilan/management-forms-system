<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registers extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_register';

    public function values(){
        return $this->hasMany('App\Values', 'id_register');
    }
}
