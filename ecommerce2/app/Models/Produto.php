<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $table = "Produto";
    protected $filable = [
        'nome',
        'marca',
        'quantidade'
    ];
}
