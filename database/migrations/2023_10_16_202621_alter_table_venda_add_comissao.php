<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('venda', function (Blueprint $table) {
            $table->float('comissao', 8, 2);
            $table->float('percentual_comissao', 8, 2)->default(8.5);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendedor', function (Blueprint $table) {
            $table->dropColumn(['comissao', 'percentual_comissao']);
        });
    }
};
