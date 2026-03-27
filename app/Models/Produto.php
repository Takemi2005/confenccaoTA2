<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produto extends Model
{
    protected $guarded = [];

    public function estoques(): HasMany
    {
        return $this->hasMany(Estoque::class);
    }

    public function getSaldoEstoqueAttribute(): float
    {
        $entradas = $this->estoques()->where('tipo', 'entrada')->sum('quantidade');
        $saidas   = $this->estoques()->where('tipo', 'saida')->sum('quantidade');
        return $entradas - $saidas;
    }
    public function movimentacoes()
    {
        return $this->hasMany(MovimentacaoEstoque::class);
    }
}
    