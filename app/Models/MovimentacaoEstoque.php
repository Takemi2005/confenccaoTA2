<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimentacaoEstoque extends Model
{
   protected $fillable = [
        'cliente_id',
        'status',
        'valor_total',
    ];
    public function movimentacoes()
    {
        return $this->hasMany(MovimentacaoEstoque::class);
    }
}

    