<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('type', ['particulier', 'entreprise'])->default('particulier');
            $table->string('name');
            $table->string('ifu')->nullable(); // uniquement si entreprise
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->uuid('city_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
