<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productor extends Model
{
    //
    protected $fillable = [
        'idProductor', 'apellido', 'nombre','region'
    ];
}
