<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Systems extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_system';

    protected $fillable = [
        'company_id',
        'name_system',
        'description_system',
        'url_system',
        'created_by',
        'updated_by'
    ];
    public function company(){
        return $this->belongsTo('App\Companies', 'company_id');
    }
    public function forms(){
        return $this->hasMany('App\Forms', 'id_system');
    }
    public function scopeWithWhereHas($query, $relation, $constraint){
        return $query->whereHas($relation, $constraint)
        ->with([$relation => $constraint]);
    }
}
