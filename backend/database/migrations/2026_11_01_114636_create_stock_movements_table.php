<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('material_id');
            $table->foreign('material_id')->references('id')->on('materials');
            $table->enum('type', ['sortie', 'retour', 'vente', 'ajustement']);
            $table->unsignedInteger('quantity');
            $table->uuid('document_id')->nullable(); // lié à une facture (phase 2)
            $table->uuid('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->uuid('city_id')->nullable();
            $table->date('moved_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
