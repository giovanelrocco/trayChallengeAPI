<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        DB::statement("UPDATE venda SET comissao = valor * .085 WHERE percentual_comissao IS NULL");
        DB::table('venda')
            ->where('percentual_comissao', null)
            ->update(['percentual_comissao' => 8.5]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
