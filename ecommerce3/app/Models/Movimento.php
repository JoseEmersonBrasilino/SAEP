<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movimento extends Model
{
    //colocamos o que é necessário no BD
protected $fillable = [
    'produto_id', 'quantidade', 'tipo'
];
public function produto(){
    return $this->hasMany(Produto::class,'produto_id');

}

}

