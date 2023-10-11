<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vendedor extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'email',
    ];

    /**
     * Tabela associada.
     *
     * @var string
     */
    protected $table = 'vendedor';

    /**
     * Busca as vendas.
     */
    public function venda(): HasMany
    {
        return $this->hasMany(Venda::class);
    }
}
