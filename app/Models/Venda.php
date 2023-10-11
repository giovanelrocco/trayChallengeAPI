<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];

    /**
     * Tabela associada.
     *
     * @var string
     */
    protected $table = 'venda';
}
