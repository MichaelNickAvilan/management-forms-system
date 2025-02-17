<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forms extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_form';

    protected $fillable = [
        'id_system',
        'name_form',
        'description_form',
        'created_by',
        'updated_by'
    ];
    public function system(){
        return $this->belongsTo('App\Systems', 'id_system');
    }
    public function fields(){
        return $this->hasMany('App\Fields', 'id_form');
    }
}
