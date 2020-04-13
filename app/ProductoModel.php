<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductoModel extends Model
{
    //
    protected $table = 'producto';
    protected $filltable = ['nombre', 'cantidad', 'precio', 'estado'];
}
