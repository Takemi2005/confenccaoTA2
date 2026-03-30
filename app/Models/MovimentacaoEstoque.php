<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimentacaoEstoque extends Model
{
    use HasFactory;


    protected $table = 'movimentacoes_estoque';


    protected $fillable = [
        'produto_id',
        'tipo',
        'quantidade',
        'observacao',
    ];


    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

   
    protected static function booted()
    {
        
        static::created(function ($movimentacao) {
            $produto = $movimentacao->produto;

            if ($movimentacao->tipo === 'entrada') {
                $produto->estoque += $movimentacao->quantidade;
            } else {
                // Se for saída, ele subtrai
                $produto->estoque -= $movimentacao->quantidade; 
            }

            $produto->save();
        });
    }
}
    