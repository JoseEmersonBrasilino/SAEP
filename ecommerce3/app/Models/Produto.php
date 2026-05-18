<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    // Adicione os campos que o Filament vai preencher automaticamente
    protected $fillable = [
        'nome',
        'preco',
        'descricao',
        'em_estoque',
    ];
}