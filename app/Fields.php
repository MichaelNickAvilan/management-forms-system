<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fields extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_field';

    public function form(){
        return $this->belongsTo('App\Forms', 'id_form');
    }
}
