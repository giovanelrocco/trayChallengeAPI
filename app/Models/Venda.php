<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Venda extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'vendedor_id',
        'valor',
        'data_venda',
        'comissao',
        'percentual_comissao',
    ];

    /**
     * Tabela associada.
     *
     * @var string
     */
    protected $table = 'venda';

    /**
     * Busca o vendedor.
     */
    public function vendedor(): BelongsTo
    {
        return $this->belongsTo(Vendedor::class);
    }
}
