<?php

namespace App\Filament\Resources\Movimentos\Pages;

use App\Filament\Resources\Movimentos\MovimentoResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Produto;
use Filament\Notifications\Notification; // Importação obrigatória para usar as notificações
class CreateMovimento extends CreateRecord
{
    protected static string $resource = MovimentoResource::class;

    // Hook - verificar antes de criar se há estoque suficiente
    protected function beforeCreate(): void
    {
        $data = $this->data;
        $produto = Produto::find($data['produto_id']);
        $quantidade = (int) $data['quantidade'];
        $tipo = $data['tipo'];

        // 1. Verifica se o produto realmente existe para evitar o erro "on null"
        if (! $produto) {
            Notification::make()
                ->title('Erro de validação')
                ->body('O produto selecionado não foi encontrado no banco de dados.')
                ->danger()
                ->send();
            
            $this->halt();
        }

        // 2. Verifica a lógica de saída de estoque
        if ($tipo === 'saida' && $quantidade > $produto->estoque) {
            Notification::make()
                ->title('Estoque insuficiente')
                ->body("Estoque de '{$produto->nome}' é de apenas {$produto->estoque} unidades.") // Corrigido para body()
                ->danger() 
                ->send(); 
            
            $this->halt(); 
        }
    }

    // Hook - Diminuir ou aumentar o estoque após a criação do registro
    protected function afterCreate(): void
    {
        $movimento = $this->getRecord();
        $produto = $movimento->produto;

        // Garante que a relação retornou um produto válido
        if ($produto) {
            if ($movimento->tipo === 'entrada') {
                $produto->increment('estoque', $movimento->quantidade);
            } else {
                $produto->decrement('estoque', $movimento->quantidade);
            }
        }
    }
}