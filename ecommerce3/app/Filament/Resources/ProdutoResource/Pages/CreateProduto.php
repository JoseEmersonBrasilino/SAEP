<?php

namespace App\Filament\Resources\ProdutoResource\Pages;

use App\Filament\Resources\ProdutoResource;
use Filament\Actions;
use Filament\Resources\Pages\Notification;

class CreateProduto extends CreateRecord
{
    protected static string $resource = MovimentoResource::class;
}
//antes de criar
protected function beforeCreate(): void 
{
    $data=$this->data;
    $produto = produto::find($data['produto_id']);
    $quantidade = (int)$data['quantidade'];
    $tipo = $data['tipo'];

    if ($tipo== 'saida' && $quantidade >$produto->estoque){
        notification::make() //make: cria notificaçao que vai aprecer em verm
        ->title ('estoque isnuficiente')
        ->body("estouque de '{$produto->nome}'é de  apenas {$produto->esto}")
        ->send(); //
        $this->hart(); //
    }
}