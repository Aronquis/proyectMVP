<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produccion extends Model
{
    //
    protected $fillable = [
        'id', 'cantidadBotellas', 'vinos_idVino','productores_idProductor'
    ];
}
